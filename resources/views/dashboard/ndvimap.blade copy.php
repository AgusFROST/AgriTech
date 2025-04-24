@extends('layouts.backend')

@section('title', 'NDVI Map Analysis')

@section('content')

    <div class="ndvi-map">
        <h2 class="h6">NDVI Map Analysis</h2>

        <div class="row">
            <div class="col-lg-9">
                <div class="bg-secondary text-white text-center py-5 rounded mb-4">

                    <!-- Then your map -->
                    <div id="ndvi-map" class="rounded mb-4"></div>

                    <script>
                        // Initialize the map
                        var map = L.map('ndvi-map').setView([-7.294298, 108.828461], 12);

                        // Rest of your map code...
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        // NDVI Layer
                        L.tileLayer(
                            'https://earthengine.googleapis.com/v1/projects/dimas1/maps/d9e4f41022d4249a0cc680b25c128b06-b32038de8d6a0046f3f4a812fd6106e8/tiles/{z}/{x}/{y}', {
                                attribution: 'NDVI from Sentinel-2 | Google Earth Engine',
                                opacity: 0.7
                            }
                        ).addTo(map);
                    </script>
                </div>

            </div>
            <div class="col-lg-3">

                <div class="col">
                    <h3 class="h6">NDVI Scale</h3>
                    <ul class="list-unstyled">
                        <li><input type="radio" name="ndvi-scale" id="high-vegetation" checked> <label
                                for="high-vegetation">High Vegetation (0.8-1.0)</label></li>
                        <li><input type="radio" name="ndvi-scale" id="moderate-vegetation"> <label
                                for="moderate-vegetation">Moderate Vegetation (0.4-0.8)</label></li>
                        <li><input type="radio" name="ndvi-scale" id="low-vegetation"> <label for="low-vegetation">Low
                                Vegetation (0.2-0.4)</label></li>
                        <li><input type="radio" name="ndvi-scale" id="no-vegetation"> <label for="no-vegetation">No
                                Vegetation (0.0-0.2)</label></li>
                    </ul>
                </div>
                <div class="col">
                    <h3 class="h6">Time Period</h3>
                    <select class="form-select mb-3">
                        <option>January 2025</option>
                    </select>
                    <h3 class="h6">Area Filter</h3>
                    <select class="form-select">
                        <option>All Areas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="test mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h6">Vegetation Change Over Time</h2>
            <select class="form-select w-auto">
                <option>Last 6 Months</option>
            </select>
        </div>
        <div class="bg-secondary text-white text-center py-5 rounded mb-4">
            Vegetation Change Graph
        </div>
        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Average NDVI</h3>
                        <p class="h4 mb-0">0.75</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Change Rate</h3>
                        <p class="h4 mb-0">+2.3%</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Healthy Areas</h3>
                        <p class="h4 mb-0">85%</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6">Alert Areas</h3>
                        <p class="h4 mb-0">3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
