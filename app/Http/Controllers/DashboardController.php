<?php

namespace App\Http\Controllers;

use App\Models\Ndvi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;


class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data NDVI terbaru
        $ndvi = NDVI::latest()->first();

        // Total lahan dan prediksi panen bisa Anda atur manual atau dari tabel lain jika ada.
        $totalLahan = 14258 ; // misalnya tetap 250 Ha
        $prediksiPanen = 750; // misalnya tetap 750 Ton

        return view('dashboard.dashboard', [
            'totalLahan' => $totalLahan,
            'prediksiPanen' => $prediksiPanen,
            'kesehatanPersen' => $ndvi ? $ndvi->healthy_percentage : null,
            'ndviAverage' => $ndvi ? $ndvi->avg_ndvi : null,
            'alertCount' => $ndvi ? $ndvi->alert_count : 0,
        ]);
    }

    public function map()
    {
        return view('dashboard.map');
    }

    // Di controller
    public function ndvimap()
    {
        $ndvi = Ndvi::latest()->first();

        return view('dashboard.ndvi.ndvimap', compact('ndvi'));
    }



public function getNdviData()
{
    $ndvi = Ndvi::latest()->first();

    // Jika ingin baca dari file CSV hasil upload sebelumnya
    // pastikan file-nya disimpan di storage dan kita simpan path-nya
    // Dalam contoh ini kita langsung buat data dummy

    // Contoh data dummy jika belum ada CSV tersimpan
    $data = [
        ['date' => '2024-01', 'mean_ndvi' => 0.41],
        ['date' => '2024-02', 'mean_ndvi' => 0.45],
        ['date' => '2024-03', 'mean_ndvi' => 0.48],
        ['date' => '2024-04', 'mean_ndvi' => 0.51],
        ['date' => '2024-05', 'mean_ndvi' => 0.49],
        ['date' => '2024-06', 'mean_ndvi' => 0.53],
    ];

    // Hitung change rate (selisih antara NDVI awal dan akhir)
    $first = $data[0]['mean_ndvi'] ?? 0;
    $last = end($data)['mean_ndvi'] ?? 0;
    $changeRate = round($last - $first, 3);

    return response()->json([
        'series' => $data,
        'avg_ndvi' => round($ndvi->avg_ndvi ?? 0, 3),
        'change_rate' => $changeRate,
        'healthy_percentage' => round($ndvi->healthy_percentage ?? 0, 1),
        'alert_count' => $ndvi->alert_count ?? 0,
    ]);
}


    public function showNdvi()
    {
        $ndvi = Ndvi::latest()->first();
        return view('dashboard.ndvi.ndviUpdate', compact('ndvi'));
    }


    public function updateNdvi(Request $request)
        {
            $request->validate([
                'url' => 'required|string|max:255',
            ]);

            // Jika hanya ada satu data NDVI, kita update yang terakhir (atau buat baru jika belum ada)
            $ndvi = Ndvi::latest()->first();

            if ($ndvi) {
                $ndvi->update(['url' => $request->url]);
            } else {
                $ndvi = Ndvi::create(['url' => $request->url]);


            }

            return redirect()->back()->with('success', 'NDVI berhasil diperbarui.');
        }

    public function updateNdviCsv(Request $request)
    {


        $request->validate([
            'vegetation' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('vegetation');
        $data = array_map('str_getcsv', file($file));

        // Anggap header = ['date', 'mean_ndvi']
        $header = array_map('strtolower', $data[0]);
        unset($data[0]);

        $ndviValues = [];
        $healthyCount = 0;
        $alertCount = 0;

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
            $ndvi = floatval($rowData['mean_ndvi'] ?? 0);
            $ndviValues[] = $ndvi;

            if ($ndvi > 0.5) $healthyCount++;
            if ($ndvi < 0.2) $alertCount++;
        }

        $avgNdvi = count($ndviValues) > 0 ? array_sum($ndviValues) / count($ndviValues) : 0;
        $healthyPercentage = count($ndviValues) > 0 ? ($healthyCount / count($ndviValues)) * 100 : 0;

        // Simpan ke database
        $ndvi = new Ndvi();
        $ndvi->url = $request->url ?? '-'; // default jika tidak ada
        $ndvi->avg_ndvi = $avgNdvi;
        $ndvi->healthy_percentage = $healthyPercentage;
        $ndvi->alert_count = $alertCount;
        $ndvi->save();

        return redirect()->back()->with('success', 'CSV berhasil diproses dan data disimpan.');
    }


public function editProfile()
    {
        $user = Auth::user();
        return view('dashboard.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->uid},uid",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dashboard.settings')->with('success', 'Profile updated successfully.');
    }


}
