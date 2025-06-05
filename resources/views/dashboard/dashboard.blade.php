@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Total Lahan</h5>
                        <i class="fas fa-chart-area"></i>
                    </div>
                    <h2 class="card-text">{{ $totalLahan }} Ha</h2>
                    <p class="card-text text-muted">+5% dari bulan lalu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Prediksi Panen</h5>
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h2 class="card-text">{{ $prediksiPanen }} Ton</h2>
                    <p class="card-text text-muted">Estimasi Maret 2025</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title">Kesehatan Tanaman</h5>
                        <i class="fas fa-heart"></i>
                    </div>
                    <h2 class="card-text">
                        {{ $kesehatanPersen !== null ? number_format($kesehatanPersen, 2) . '%' : 'Data tidak tersedia' }}
                    </h2>
                    <p class="card-text text-muted">
                        Rata-rata : {{ $ndviAverage !== null ? number_format($ndviAverage, 3) : 'N/A' }},
                        Alert: {{ $alertCount }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prediksi Hasil Panen</h5>
                    <div class="bg-dark-subtle p-5 text-center">
                        Grafik Prediksi Panen 2025
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistik Pertanian</h5>
                    <div class="bg-dark-subtle p-5 text-center">
                        Grafik Statistik Pertanian
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Analisis Historis</h5>
            <div class="bg-dark-subtle p-5 text-center">
                Grafik Data Historis Panen
            </div>
        </div>
    </div>
    </div>

@endsection
