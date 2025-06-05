@extends('layouts.backend')

@section('title', 'NDVI Map Analysis')

@section('content')

    <div class="ndvi-map">
        <h2 class="h6">NDVI Map Analysis</h2>

        <div class="row">
            <!-- Kolom Peta -->
            <div class="col-lg-9">
                <div class="bg-secondary text-white text-center py-3 rounded mb-4">

                    <!-- Container Peta -->
                    <div id="ndvi-map" style="height: 500px;" class="rounded mb-4"></div>
                </div>
            </div>

            <!-- Kolom NDVI Scale -->
            <div class="col-lg-3">
                <div class="col">
                    <h3 class="h6">NDVI Scale</h3>
                    <ul class="list-unstyled">
                        <li><input type="radio" name="ndvi-scale" id="high-vegetation" checked>
                            <label for="high-vegetation">High Vegetation (0.8–1.0)</label>
                        </li>
                        <li><input type="radio" name="ndvi-scale" id="moderate-vegetation">
                            <label for="moderate-vegetation">Moderate Vegetation (0.4–0.8)</label>
                        </li>
                        <li><input type="radio" name="ndvi-scale" id="low-vegetation">
                            <label for="low-vegetation">Low Vegetation (0.2–0.4)</label>
                        </li>
                        <li><input type="radio" name="ndvi-scale" id="no-vegetation">
                            <label for="no-vegetation">No Vegetation (0.0–0.2)</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="test mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h6">Vegetation Change Over Time</h2>
        </div>

        <div class="text-white text-center py-5 rounded mb-4" id="ndvi-graph">
            Loading vegetation graph...
        </div>

        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Average NDVI</h3>
                        <p class="h4 mb-0" id="avg-ndvi">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Change Rate</h3>
                        <p class="h4 mb-0" id="change-rate">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Healthy Areas</h3>
                        <p class="h4 mb-0" id="healthy-areas">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Alert Areas</h3>
                        <p class="h4 mb-0" id="alert-areas">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('ndvi-map').setView([-7.294298, 108.828461], 12);

            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            const ndviUrl = '{{ $ndvi->url }}';
            const ndviLayer = L.tileLayer(ndviUrl, {
                attribution: 'NDVI from Sentinel-2 | Google Earth Engine',
                opacity: 1.0,
                maxZoom: 20
            }).addTo(map);

            const layersControl = L.control.layers({
                "OpenStreetMap": osmLayer
            }, {
                "NDVI Layer": ndviLayer
            }).addTo(map);

            // ✅ EasyPrint setup
            const printer = L.easyPrint({
                tileLayer: ndviLayer, // Ganti dari osmLayer ke ndviLayer jika ingin export NDVI
                sizeModes: ['Current'],
                filename: 'NDVI-Map',
                exportOnly: true,
                hideControlContainer: false
            }).addTo(map);

            // ✅ Event export
            document.getElementById('export-map').addEventListener('click', function() {
                try {
                    printer.printMap('CurrentSize', 'NDVI-Map');
                } catch (e) {
                    alert('Export failed: ' + e.message);
                }
            });

            // ✅ NDVI scale opacity control
            document.querySelectorAll('input[name="ndvi-scale"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const opacityMap = {
                        'high-vegetation': 1.0,
                        'moderate-vegetation': 0.75,
                        'low-vegetation': 0.5,
                        'no-vegetation': 0.3
                    };
                    ndviLayer.setOpacity(opacityMap[this.id]);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('dashboard.ndvi.data') }}")
                .then(res => res.json())
                .then(data => {
                    // Update stat
                    document.getElementById('avg-ndvi').textContent = data.avg_ndvi;
                    document.getElementById('change-rate').textContent = data.change_rate;
                    document.getElementById('healthy-areas').textContent = data.healthy_percentage + '%';
                    document.getElementById('alert-areas').textContent = data.alert_count;

                    // Render chart
                    const labels = data.series.map(row => row.date);
                    const values = data.series.map(row => row.mean_ndvi);

                    const canvas = document.createElement('canvas');
                    document.getElementById('ndvi-graph').innerHTML = '';
                    document.getElementById('ndvi-graph').appendChild(canvas);

                    new Chart(canvas, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'NDVI Mean',
                                data: values,
                                borderColor: 'green',
                                backgroundColor: 'rgba(0,128,0,0.1)',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    suggestedMin: 0,
                                    suggestedMax: 1
                                }
                            }
                        }
                    });
                })
                .catch(err => {
                    console.error('NDVI graph load failed', err);
                    document.getElementById('ndvi-graph').textContent = 'Failed to load graph';
                });
        });
    </script>


@endsection
