@extends('landing.layouts.layout')
@section('title', 'Naik Angkot')





@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="text-center mb-3">Mulai Naik Angkot</h5>

                                <!-- Notifikasi -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
                                @endif

                                {{-- Tampilkan Semua Error dalam Satu Div --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li class="small">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Form Naik Angkot -->
                                <form action="{{ route('ride.process') }}" method="POST">
                                    @csrf

                                    <!-- Info Awal -->
                                    <div class="text-center" id="infoAwal">
                                        <img src="{{ asset('assets/img/yuk_angkot.png') }}" alt="Angkot Ilustrasi" width="100%">
                                    </div>


                                    <!-- Info Angkot -->

                                    <div id="angkotInfo" class="mt-3"></div>

                                    <!-- Peta Lokasi Naik -->
                                    <div id="mapContainer" class="mt-3" style="height: 250px; display: none;">
                                        <div id="map" style="height: 100%; width: 100%;" class="rounded shadow-sm"></div>
                                    </div>

                                    <!-- Tombol Scan QR -->
                                    <div class="text-center mb-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="scanQR">
                                            📷 Scan QR Angkot
                                        </button>
                                        <input type="hidden" name="qrcode_string" id="qrcode_string">
                                    </div>

                                    <!-- QR Reader -->
                                    <div id="qr-scanner-container" class="mb-3 text-center" style="display: none;">
                                        <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>
                                        <button type="button" class="btn btn-danger btn-sm mt-2" id="stopScan">❌ Stop Scan</button>
                                    </div>




                                    <!-- Info Lokasi -->
                                    <div class="mb-2">
                                        <label class="form-label">Lokasi Naik</label>
                                        <input type="text" class="form-control form-control-sm" name="geton_location" id="geton_location" readonly required>
                                    </div>

                                    <input type="hidden" name="geton_latitude" id="geton_latitude">
                                    <input type="hidden" name="geton_longitude" id="geton_longitude">

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('customer.home') }}" class="btn btn-secondary btn-sm">🔙 Kembali</a>
                                        <button type="submit" class="btn btn-success btn-sm" id="startTripBtn" disabled>
                                            🚀 Mulai Perjalanan
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script: QR + Geolocation -->

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('startTripBtn');

            form.addEventListener('submit', function(e) {
                // Cegah submit ganda
                submitBtn.disabled = true;

                // Ganti teks tombol jadi loading spinner
                submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memulai...
            `;
            });
        });

        let scanner;

        // Mulai QR Scan
        document.getElementById('scanQR').addEventListener('click', function() {
            document.getElementById('qr-scanner-container').style.display = 'block';
            document.getElementById('infoAwal').style.display = 'none';
            scanner = new Html5Qrcode("reader");
            scanner.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                (decodedText) => {
                    document.getElementById('qrcode_string').value = decodedText;
                    document.getElementById('scanQR').style.display = 'block';
                    // Sembunyikan tombol scan setelah berhasil
                    document.getElementById('scanQR').style.display = 'none';

                    stopScanning();
                    getCurrentLocation();
                    fetchAngkotData(decodedText); // Tambahkan ini
                },
                (errorMessage) => console.warn("QR scan error:", errorMessage)
            ).catch(err => {
                console.error(err);
                alert("Gagal mengakses kamera.");
            });
        });

        document.getElementById('stopScan').addEventListener('click', stopScanning);

        function stopScanning() {
            if (scanner) {
                scanner.stop().then(() => {
                    document.getElementById('qr-scanner-container').style.display = 'none';
                }).catch(err => console.error("Error stopping scanner:", err));
            }
        }

        // Ambil Lokasi & Reverse Geocoding
        // Ambil Lokasi & Reverse Geocoding + Peta
        function getCurrentLocation() {

            const startTripBtn = document.getElementById('startTripBtn');
            startTripBtn.disabled = true;
            startTripBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengambil Lokasi...`;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        document.getElementById('geton_latitude').value = lat;
                        document.getElementById('geton_longitude').value = lng;

                        // Tampilkan Peta
                        document.getElementById('mapContainer').style.display = 'block';
                        showMap(lat, lng);

                        // Reverse geocoding
                        const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
                        try {
                            const res = await fetch(url);
                            const data = await res.json();
                            console.log('data');
                            console.log(data);
                            const address = data.display_name || "Tidak Diketahui";
                            document.getElementById('geton_location').value = address;
                        } catch (err) {
                            console.error("Reverse geocoding failed:", err);
                            document.getElementById('geton_location').value = "Gagal Mendapatkan Lokasi";
                        }

                        // Aktifkan kembali tombol
                        startTripBtn.disabled = false;
                        startTripBtn.innerHTML = '🚀 Mulai Perjalanan';

                    },
                    function(error) {
                        alert("Gagal mendapatkan lokasi. Pastikan izin GPS aktif.");
                        startTripBtn.disabled = false;
                        startTripBtn.innerHTML = '🚀 Mulai Perjalanan';
                    });
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
                startTripBtn.disabled = false;
                startTripBtn.innerHTML = '🚀 Mulai Perjalanan';
            }
        }


        function fetchAngkotData(id) {
            fetch(`/customer/angkot/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal mengambil data angkot");
                    return response.json();
                })
                .then(data => {
                    // Tampilkan datanya di UI
                    displayAngkotData(data);
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    alert("Gagal memuat data angkot.");
                    window.location.reload(); // Tambahkan ini untuk reload halaman


                });
        }

        function showMap(lat, lng) {
            const map = L.map('map').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('Lokasi Naik Anda')
                .openPopup();
        }

        function displayAngkotData(data) {
            const infoContainer = document.getElementById('angkotInfo');
            if (!infoContainer) return;

            // infoContainer.innerHTML = `
        //     <div class="card mb-2 border">
        //         <div class="card-body p-2">
        //             <div class="d-flex">
        //                 <img src="${data.vehicle.vehicle_photo}" alt="Foto Kendaraan" class="me-3 rounded" width="100">
        //                 <div>
        //                     <h6 class="mb-1">${data.name}</h6>
        //                     <p class="mb-0 text-muted">📱 ${data.mobile_phone}</p>
        //                     <p class="mb-0 text-muted">🚘 ${data.vehicle.license_plate}</p>
        //                 </div>
        //             </div>
        //         </div>
        //     </div>
        // `;


            infoContainer.innerHTML = `<h6 class="text-muted">Detail Pengendara</h6>
            <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <span class="text-dark font-weight-bold">
                                            Nama Supir
                                        </span>
                                        <span>${data.name}</span>
                                    </div>

                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <span class="text-dark font-weight-bold">
                                            Plat Nomor
                                        </span>
                                        <span>${data.vehicle.license_plate}</span>
                                    </div>
            `;

        }
    </script>
@endsection
