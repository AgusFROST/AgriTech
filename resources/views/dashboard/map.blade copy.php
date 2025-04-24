@extends('layouts.backend')

@section('title', 'Peta Interaktif Lahan')

@section('content')
    <div class="row">
        <!-- Interactive Map Section -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Peta Interaktif Lahan</h5>

                    <div id="map"></div>

                    <!-- MapLibre GL JS -->
                    <script src="https://unpkg.com/maplibre-gl@3.2.1/dist/maplibre-gl.js"></script>

                    <script>
                        const map = new maplibregl.Map({
                            container: 'map',
                            style: 'https://basemap.mapid.io/styles/basic/style.json?key=68044ba2ce3f3583122422bf',
                            center: [108.8284617927, -7.2942982817],
                            zoom: 14
                        });


                        map.addControl(new maplibregl.NavigationControl());
                    </script>

                    <!-- Button for Layer and Zoom Controls -->
                    <div class="d-flex mt-3">
                        <button class="btn btn-custom mr-2">
                            <i class="fas fa-layer-group"></i> Layer
                        </button>
                        <button class="btn btn-custom">
                            <i class="fas fa-search"></i> Zoom
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Cuaca Real-time</h5>
                    <h6>
                        <span id="area-name">Memuat...</span>
                    </h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-thermometer-half"></i> Suhu</span>
                        <span id="temperature">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-tint"></i> Kelembaban</span>
                        <span id="humidity">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-wind"></i> Kecepatan Angin</span>
                        <span id="wind-speed">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-compass"></i> Arah Angin</span>
                        <span id="wind-direction">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-cloud-sun"></i> Cuaca</span>
                        <span id="weather-desc">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-clock"></i> Waktu Pengamatan</span>
                        <span id="observation-time">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-calendar-alt"></i> Valid Sampai</span>
                        <span id="valid-until">Memuat...</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-info-circle"></i> Sumber Data</span>
                        <span>BMKG</span>
                    </div>
                </div>
            </div>

            <script>
                async function getWeather() {
                    const endpoint = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=33.01.13.2006';

                    // Show loading state
                    const loadingElements = document.querySelectorAll(
                        '#area-name, #temperature, #humidity, #wind-speed, #wind-direction, #weather-desc, #observation-time, #valid-until'
                    );
                    loadingElements.forEach(el => el.textContent = "Memuat...");

                    try {
                        const response = await fetch(endpoint);

                        if (!response.ok) {
                            throw new Error(`Gagal mengambil data: ${response.status}`);
                        }

                        const data = await response.json();

                        // Validate response structure
                        if (!data || typeof data !== 'object' || !data.data || !Array.isArray(data.data)) {
                            throw new Error('Format data tidak valid');
                        }

                        // Extract location data
                        let areaName = "Lokasi tidak diketahui";
                        if (data.lokasi) {
                            areaName =
                                `Desa ${data.lokasi.desa}, ${data.lokasi.kecamatan}, ${data.lokasi.kotkab}, ${data.lokasi.provinsi}`;
                        }
                        document.getElementById("area-name").textContent = areaName;

                        // Process weather data
                        let allForecasts = [];

                        // Extract all forecasts from nested arrays
                        data.data.forEach(locationData => {
                            if (locationData.cuaca && Array.isArray(locationData.cuaca)) {
                                locationData.cuaca.forEach(forecastGroup => {
                                    if (Array.isArray(forecastGroup)) {
                                        allForecasts = allForecasts.concat(forecastGroup);
                                    }
                                });
                            }
                        });

                        if (allForecasts.length === 0) {
                            throw new Error('Tidak ada data cuaca yang tersedia');
                        }

                        // Sort forecasts by local_datetime
                        allForecasts.sort((a, b) => {
                            return new Date(a.local_datetime) - new Date(b.local_datetime);
                        });

                        const now = new Date();
                        let currentForecast = null;
                        let nextForecast = null;

                        // Find the current or next forecast
                        for (let i = 0; i < allForecasts.length; i++) {
                            const forecastTime = new Date(allForecasts[i].local_datetime);

                            if (forecastTime >= now) {
                                currentForecast = allForecasts[i];
                                nextForecast = allForecasts[i + 1] || null;
                                break;
                            }
                        }

                        // If no current forecast found (all forecasts are in the past), use the last one
                        if (!currentForecast) {
                            currentForecast = allForecasts[allForecasts.length - 1];
                        }

                        // Display the weather data
                        if (currentForecast) {
                            document.getElementById("temperature").textContent = currentForecast.t !== undefined ?
                                `${currentForecast.t} °C` : "Tidak tersedia";
                            document.getElementById("humidity").textContent = currentForecast.hu !== undefined ?
                                `${currentForecast.hu}%` : "Tidak tersedia";
                            document.getElementById("wind-speed").textContent = currentForecast.ws !== undefined ?
                                `${currentForecast.ws} km/jam` : "Tidak tersedia";

                            let windDirection = "Tidak tersedia";
                            if (currentForecast.wd && currentForecast.wd_deg) {
                                windDirection = `${currentForecast.wd} (${currentForecast.wd_deg}°)`;
                            } else if (currentForecast.wd) {
                                windDirection = currentForecast.wd;
                            }
                            document.getElementById("wind-direction").textContent = windDirection;

                            document.getElementById("weather-desc").textContent = currentForecast.weather_desc ||
                                currentForecast.weather_desc_en || "Tidak tersedia";

                            // Format observation time
                            const obsTime = new Date(currentForecast.local_datetime);
                            document.getElementById("observation-time").textContent = obsTime.toLocaleString('id-ID', {
                                weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            // Format valid until time
                            if (nextForecast) {
                                const validTime = new Date(nextForecast.local_datetime);
                                document.getElementById("valid-until").textContent = validTime.toLocaleString('id-ID', {
                                    weekday: 'long',
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            } else {
                                document.getElementById("valid-until").textContent = "Tidak diketahui";
                            }
                        }

                    } catch (error) {
                        console.error("Error fetching weather data:", error);

                        // Show user-friendly error messages
                        document.getElementById("area-name").textContent = "Gagal memuat data";
                        document.getElementById("temperature").textContent = "-";
                        document.getElementById("humidity").textContent = "-";
                        document.getElementById("wind-speed").textContent = "-";
                        document.getElementById("wind-direction").textContent = "-";
                        document.getElementById("weather-desc").textContent = "Gagal memuat data cuaca";
                        document.getElementById("observation-time").textContent = "-";
                        document.getElementById("valid-until").textContent = "-";
                    }
                }

                // Initial load
                getWeather();

                // Refresh every 5 minutes
                setInterval(getWeather, 300000);
            </script>

            <!-- Warning Status Section -->

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Status Peringatan</h5>
                    <div id="warning-container">
                        <div class="alert alert-warning mb-3">
                            <strong><i class="fas fa-exclamation-triangle"></i> Memuat Peringatan...</strong>
                            <p class="mb-0">Sedang mengambil data peringatan cuaca</p>
                            <small class="text-muted">Terakhir diperbarui: <span id="warning-update">-</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Fungsi untuk mengambil data peringatan dari Weather.gov
            async function getWeatherAlerts() {
                try {
                    // Pertama kita perlu mendapatkan lokasi (contoh untuk Cilacap)
                    const lat = -7.2942982817;
                    const lon = 108.8284617927;

                    // Endpoint Weather.gov untuk alerts
                    const alertResponse = await fetch(`https://api.weather.gov/alerts/active?point=${lat},${lon}`, {
                        headers: {
                            'User-Agent': 'MyWeatherApp/1.0 (tanger151124@gmail.com)'
                        }
                    });

                    if (!alertResponse.ok) {
                        throw new Error(`Gagal mengambil data peringatan: ${alertResponse.status}`);
                    }

                    const alertData = await alertResponse.json();
                    const now = new Date();

                    // Update timestamp
                    document.getElementById('warning-update').textContent = now.toLocaleString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Kosongkan container peringatan
                    const warningContainer = document.getElementById('warning-container');
                    warningContainer.innerHTML = '';

                    // Jika tidak ada peringatan
                    if (!alertData.features || alertData.features.length === 0) {
                        warningContainer.innerHTML = `
                            <div class="alert alert-success">
                                <strong><i class="fas fa-check-circle"></i> Tidak Ada Peringatan</strong>
                                <p class="mb-0">Tidak ada peringatan cuaca aktif untuk wilayah ini</p>
                                <small class="text-muted">Terakhir diperbarui: <span>${now.toLocaleString('id-ID')}</span></small>
                            </div>
                        `;
                        return;
                    }

                    // Proses setiap peringatan
                    alertData.features.forEach((alert, index) => {
                        const properties = alert.properties;
                        let alertClass = 'warning';
                        let icon = 'exclamation-triangle';

                        // Tentukan jenis alert berdasarkan severity
                        if (properties.severity === 'Extreme' || properties.severity === 'Severe') {
                            alertClass = 'danger';
                            icon = 'exclamation-circle';
                        } else if (properties.severity === 'Minor') {
                            alertClass = 'info';
                            icon = 'info-circle';
                        }

                        // Format waktu
                        const effective = new Date(properties.effective).toLocaleString('id-ID');
                        const expires = new Date(properties.expires).toLocaleString('id-ID');

                        // Buat elemen alert
                        const alertElement = document.createElement('div');
                        alertElement.className = `alert alert-${alertClass} ${index > 0 ? 'mt-3' : ''}`;
                        alertElement.innerHTML = `
                            <strong><i class="fas fa-${icon}"></i> ${properties.event}</strong>
                            <p class="mb-1">${properties.headline || properties.description.substring(0, 150)}...</p>
                            <small class="d-block"><strong>Berlaku:</strong> ${effective} sampai ${expires}</small>
                            <small class="text-muted">Sumber: ${properties.senderName}</small>
                        `;

                        warningContainer.appendChild(alertElement);
                    });

                } catch (error) {
                    console.error("Error fetching weather alerts:", error);

                    const warningContainer = document.getElementById('warning-container');
                    warningContainer.innerHTML = `
                        <div class="alert alert-danger">
                            <strong><i class="fas fa-exclamation-circle"></i> Gagal Memuat Peringatan</strong>
                            <p class="mb-0">Tidak dapat mengambil data peringatan cuaca</p>
                            <small class="text-muted">Terakhir diperbarui: ${new Date().toLocaleString('id-ID')}</small>
                        </div>
                    `;
                }
            }

            // Panggil fungsi saat pertama kali load
            getWeatherAlerts();

            // Refresh setiap 5 menit (300000 ms)
            setInterval(getWeatherAlerts, 300000);
        </script>
    </div>
@endsection
