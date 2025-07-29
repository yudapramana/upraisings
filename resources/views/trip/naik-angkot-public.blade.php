@extends('landing.layouts.layout')
@section('title', 'Naik Angkot Tanpa Login')

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="text-center mb-3">Form Naik Angkot</h5>

                                @if (session('success'))
                                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('public.ride.store') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="angkot_id" value="{{ $angkot_id }}">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <input type="hidden" name="location_text" id="location_text">

                                    <div id="angkotDetail" class="mb-3"></div>

                                    <div id="mapContainer" class="mb-3" style="height: 250px; display: none;">
                                        <div id="map" style="height: 100%; width: 100%;" class="rounded shadow-sm"></div>
                                    </div>

                                    <div class="mb-2">
                                        <label for="name" class="form-label">Nama Customer</label>
                                        <input type="text" name="customer_name" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No. Handphone</label>
                                        <input type="text" name="customer_phone" class="form-control form-control-sm" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="lokasi" class="form-label">Lokasi Naik</label>
                                        <input type="text" class="form-control form-control-sm" id="lokasi_display" readonly>
                                    </div>

                                    <div class="text-end">
                                        <button id="startRideBtn" type="submit" class="btn btn-success btn-sm" disabled>🚀 Mulai Perjalanan / Naik Angkot</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const angkotId = @json($angkot_id);
            getCurrentLocation();
            fetchAngkotDetail(angkotId);
        });

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function(pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;

                        // tampilkan map
                        document.getElementById('mapContainer').style.display = 'block';
                        // const map = L.map('map').setView([lat, lng], 16);
                        const map = L.map('map', {
                            center: [lat, lng],
                            zoom: 16,

                            // 🔒 Disable interactivity
                            dragging: false,
                            touchZoom: false,
                            scrollWheelZoom: false,
                            doubleClickZoom: false,
                            boxZoom: false,
                            keyboard: false,
                            zoomControl: false,
                        });
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap'
                        }).addTo(map);
                        L.marker([lat, lng]).addTo(map).bindPopup('Lokasi Anda').openPopup();

                        // Aktifkan tombol submit
                        document.getElementById('startRideBtn').disabled = false;

                        // reverse geocoding
                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                            const data = await res.json();
                            const address = data.display_name || 'Tidak diketahui';
                            document.getElementById('lokasi_display').value = address;
                            document.getElementById('location_text').value = address;
                        } catch (e) {
                            console.error("Gagal geocoding", e);
                        }
                    },
                    function(err) {
                        alert("Izin lokasi ditolak.");
                    });
            } else {
                alert("Browser tidak mendukung geolocation.");
            }
        }

        function fetchAngkotDetail(id) {
            fetch(`/angkot/${id}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('angkotDetail');
                    container.innerHTML = `
                    <div class="mb-3 p-2 border rounded bg-white shadow-sm">
                        <strong>Nama Supir:</strong> ${data.name}<br>
                        <strong>Plat Nomor:</strong> ${data.vehicle.license_plate}<br>
                        <strong>HP:</strong> ${data.mobile_phone}
                    </div>
                `;
                })
                .catch(() => {
                    alert("Gagal mengambil data angkot.");
                });
        }
    </script>
@endsection
