@extends('layouts.backend')

@section('title', 'NDVI Update')

@section('content')
    <div class="row">
        {{-- Kiri: Panduan & Kode --}}
        <div class="col-lg-6 mb-4">
            <h4>Kunjungi Engine Earth sebelum Update</h4>
            <p class="text-muted">
                Pastikan Anda telah mendaftar telebih dahulu lalu mengunjungi
                <a href="https://code.earthengine.google.com/" target="_blank">Engine Earth</a>
                untuk mendapatkan URL NDVI yang valid.
            </p>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    Google Earth Engine Script
                    <button class="btn btn-sm btn-primary float-end" onclick="salinKode()">Salin</button>
                </div>
                <div class="card-body">
                    <pre class="mb-0"><code id="kode">
// Google Earth Engine script
// Koordinat kamu
var point = ee.Geometry.Point(108.8284617927, -7.2942982817);
var area = point.buffer(3000); // buffer 3 km, bisa diubah sesuai area yang diinginkan

// Fungsi untuk menghitung NDVI
function calculateNDVI(image) {
  var ndvi = image.normalizedDifference(['B8', 'B4']).rename('NDVI');
  return ndvi;
}

// Ambil data bulanan selama 12 bulan terakhir
var startDate = ee.Date('2024-01-01');
var endDate = ee.Date('2025-01-31');
var months = ee.List.sequence(0, 11); // 12 bulan

var monthlyNDVI = ee.ImageCollection.fromImages(
  months.map(function(month) {
    var start = startDate.advance(month, 'month');
    var end = start.advance(1, 'month');

    var image = ee.ImageCollection("COPERNICUS/S2_SR")
      .filterBounds(area)
      .filterDate(start, end)
      .sort('CLOUDY_PIXEL_PERCENTAGE')
      .first();

    return calculateNDVI(image)
      .set('system:time_start', start.millis())
      .set('month', start.format('YYYY-MM'));
  })
);

// Hitung statistik untuk setiap bulan
var monthlyStats = monthlyNDVI.map(function(image) {
  var stats = image.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: area,
    scale: 10
  });
  return ee.Feature(null, {
    'date': image.get('month'),
    'mean_ndvi': stats.get('NDVI'),
    'system:time_start': image.get('system:time_start')
  });
});

// Ekspor data time series
Export.table.toDrive({
  collection: monthlyStats,
  description: 'NDVI_TimeSeries',
  fileFormat: 'CSV'
});

// Visualisasi data terbaru
var latestImage = ee.Image(monthlyNDVI.toList(1).get(0));
var ndviParams = {min: 0, max: 1, palette: ['red', 'yellow', 'green']};
Map.centerObject(point, 12);
Map.addLayer(latestImage.clip(area), ndviParams, 'Latest NDVI');

// Buat URL Tile NDVI
var mapId = latestImage.clip(area).getMap(ndviParams);
print('Tile URL (Leaflet):', mapId.urlFormat);
               </code></pre>
                </div>
            </div>
        </div>

        {{-- Kanan: Form Update --}}
        <div class="col-lg-6">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.ndvi.update') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="url" class="form-label">NDVI URL</label>
                    <input type="text" class="form-control" name="url" id="url" required
                        value="{{ old('url', $ndvi->url ?? '') }}" placeholder="https://earthengine.googleapis.com/...">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>


            <form method="POST" action="{{ route('dashboard.ndvi.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3 mt-4">
                    <label for="vegetation" class="form-label">Upload NDVI CSV</label>
                    <input type="file" class="form-control" name="vegetation" id="vegetation" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

        </div>
    </div>

    {{-- Elemen tersembunyi untuk bantu salin kode --}}
    <textarea id="tempKode" style="position:absolute; left:-9999px; top:0;"></textarea>

    {{-- Script untuk salin kode --}}
    <script>
        function salinKode() {
            const kode = document.getElementById('kode').textContent.trim();
            const temp = document.getElementById('tempKode');
            temp.value = kode;
            temp.select();

            try {
                document.execCommand('copy');
                alert('Kode berhasil disalin!');
            } catch (err) {
                console.error('Gagal menyalin kode: ', err);
                alert('Gagal menyalin kode.');
            }
        }
    </script>
@endsection
