@extends('landing.layouts.layout')
@section('title', 'Detail Perjalanan')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    @if ($trip->status === 'completed' && $trip->geton_latitude && $trip->getoff_latitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('tripMap').setView([
                    {{ $trip->geton_latitude }},
                    {{ $trip->geton_longitude }}
                ], 13);

                // OpenStreetMap Tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Marker lokasi naik
                const getonMarker = L.marker([
                    {{ $trip->geton_latitude }},
                    {{ $trip->geton_longitude }}
                ]).addTo(map).bindPopup('📍 Lokasi Naik<br>{{ $trip->geton_location }}');

                // Marker lokasi turun
                const getoffMarker = L.marker([
                    {{ $trip->getoff_latitude }},
                    {{ $trip->getoff_longitude }}
                ]).addTo(map).bindPopup('🚩 Lokasi Turun<br>{{ $trip->getoff_location }}');

                // Gambar garis antar lokasi
                const line = L.polyline([
                    [{{ $trip->geton_latitude }}, {{ $trip->geton_longitude }}],
                    [{{ $trip->getoff_latitude }}, {{ $trip->getoff_longitude }}]
                ], {
                    color: 'blue',
                    weight: 3,
                    opacity: 0.7,
                    dashArray: '4,6'
                }).addTo(map);

                // Fokuskan peta pada kedua titik
                map.fitBounds(line.getBounds());
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('completeTripForm');
            const button = document.getElementById('completeTripBtn');

            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault(); // Cegah submit langsung

                    // Set button loading
                    button.disabled = true;
                    button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyelesaikan...`;

                    if (!navigator.geolocation) {
                        alert('Geolocation tidak didukung browser ini.');
                        form.submit();
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(async function(position) {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;

                            document.getElementById('getoff_latitude').value = latitude;
                            document.getElementById('getoff_longitude').value = longitude;

                            try {
                                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`);
                                const data = await res.json();

                                document.getElementById('getoff_location').value = data.display_name;
                                document.getElementById('getoff_geolocation').value = JSON.stringify(data);
                            } catch (err) {
                                console.warn('Gagal mendapatkan nama lokasi.', err);
                            }

                            form.submit(); // submit setelah semua data terisi
                        },
                        function(err) {
                            console.error(err);
                            form.submit(); // Tetap submit meskipun gagal ambil lokasi
                        });
                });
            }
        });
    </script>

@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0 font-weight-bold">Detail Aktivitas</h4>
                                    <span class="badge badge-pill text-white 
                                        @if ($trip->status == 'ongoing') bg-warning
                                        @elseif($trip->status == 'completed') bg-success
                                        @else bg-danger @endif
                                        px-2 py-1" style="font-size: 0.65rem;">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </div>


                                <hr />

                                <h6 class="text-muted">Detail Transaksi</h6>


                                @if (Request::segment(1) == 'partner')
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <span class="text-dark font-weight-bold">Dinaiki oleh</span>
                                        <span>{{ $trip->user->name }}</span>
                                    </div>
                                @endif


                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">Waktu Naik</span>
                                    <span>{{ $trip->created_at->format('d M, h:i A') }}</span>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">
                                        Trip {{ ucfirst($trip->status) }}
                                    </span>
                                    <span>{{ $trip->trip_transaction_id }}</span>
                                </div>

                                <hr />

                                <h6 class="text-muted">Detail Angkot</h6>

                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">Trayek</span>
                                    <span>
                                        <span class="badge border rounded text-dark font-weight-bold" style=" border-bottom-color: {{ $trip->color }} !important; border-bottom-width: 3px !important; font-size: 0.5rem;">
                                            <i class="fas fa-shuttle-van me-1" style="font-size: 0.7rem;"></i>
                                            {{ $trip->route_number }}
                                        </span>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">
                                        Rute
                                    </span>
                                    <span>{{ $trip->route_name }}</span>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">
                                        Nama Supir
                                    </span>
                                    <span>{{ $trip->driver_name }}</span>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <span class="text-dark font-weight-bold">
                                        Plat Nomor
                                    </span>
                                    <span class="badge badge-dark font-weight-bold">{{ $trip->license_plate }}</span>
                                </div>

                                <hr />

                                <h6 class="text-muted">Detail Perjalanan</h6>


                                {{-- Pickup Location --}}
                                {{-- <div class="d-flex align-items-start mb-3">
                                    <div class="text-center me-3">
                                        <div style="width: 32px; height: 32px;" class="bg-success rounded-circle d-flex justify-content-center align-items-center">
                                            <i class="fas fa-arrow-up text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">Pickup Location</small><br>
                                        @php
                                            $locationParts = explode(',', $trip->geton_location);
                                            $firstTwo = array_slice($locationParts, 0, 2);
                                            $formattedLocation = implode(',', $firstTwo);
                                        @endphp

                                        <strong class="text-dark">{{ $formattedLocation ?? '-' }}</strong>
                                    </div>
                                </div> --}}

                                {{-- Separator --}}
                                {{-- <div class="ms-2 mb-3" style="height: 20px; border-left: 2px dotted #ccc;"></div> --}}

                                {{-- Destination Location --}}
                                {{-- <div class="d-flex align-items-start">
                                    <div class="text-center me-3">
                                        <div style="width: 32px; height: 32px;" class="bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                            <i class="fas fa-circle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">n/a km</small><br>
                                        <strong class="text-dark">{{ $trip->getoff_location ?? '-' }}</strong>
                                    </div>
                                </div> --}}

                                @if ($trip->status === 'completed' && $trip->geton_latitude && $trip->getoff_latitude)
                                    <div>
                                        {{-- <h6 class="text-muted">Peta Perjalanan</h6> --}}
                                        <div id="tripMap" style="height: 250px;" class="rounded shadow-sm"></div>
                                    </div>
                                @endif

                                <div class="d-flex align-items-center mb-3 mt-4">

                                    <img src="http://res.cloudinary.com/dezj1x6xp/image/upload/v1750247146/PandanViewMandeh/panelarah_angkotapp_k37dlt.jpg" alt="Foto Kendaraan" class="img-circle elevation-2 me-4" width="27" style="object-fit: cover;">

                                    <div class="ps-1 px-3">
                                        <small class="text-dark">Get On Location</small><br>
                                        @php
                                            $locationParts = explode(',', $trip->geton_location);
                                            $firstTwo = array_slice($locationParts, 0, 2);
                                            $formattedLocation = implode(',', $firstTwo);
                                        @endphp
                                        <strong class="text-dark">{{ $formattedLocation ?? '-' }}</strong>

                                        <div class="ms-2 mb-3" style="height: 11px; border-left: 2px #ccc;"></div>

                                        <small class="text-dark">Get Off Location - {{ $trip->distance ?? 'n/a' }} km</small><br>
                                        @php
                                            if ($trip->getoff_location) {
                                                $locationParts2 = explode(',', $trip->getoff_location);
                                                $firstTwo2 = array_slice($locationParts2, 0, 2);
                                                $formattedLocation2 = implode(',', $firstTwo2);
                                            } else {
                                                $formattedLocation2 = 'On Going';
                                            }
                                        @endphp
                                        <strong class="text-dark">{{ $formattedLocation2 }}</strong>
                                    </div>
                                </div>




                                <hr />

                                <h6 class="text-muted">Detail Bayar</h6>

                                <div class="d-flex justify-content-between flex-wrap gap-2 mb-1">
                                    <span class="text-dark font-weight-bold">
                                        Biaya Trip
                                    </span>
                                    <span>Rp {{ number_format($trip->trip_fare, 0, ',', '.') }}</span>
                                </div>
                                <small class="text-muted d-block" style="font-size: 0.5rem;">
                                    *Biaya untuk perjalanan angkot berkisar antara Rp3.000 - Rp7.000 sesuai jarak tempuh per-Km
                                </small>


                                {{-- Tambahkan warning jika metode cash --}}
                                @if ($trip->payment_method === 'cash')
                                    <div class="alert alert-danger p-2 small mb-3" role="alert">
                                        <strong>Perhatian!</strong> Silakan lakukan pembayaran <strong>tunai (cash)</strong> langsung kepada supir angkot.
                                    </div>
                                @else
                                    <div class="alert alert-success p-2 small mb-3" role="alert">
                                        <strong>Pembayaran Berhasil!</strong> Biaya perjalanan ini telah dibayarkan melalui <strong>sistem (saldo e-wallet)</strong>.
                                    </div>
                                @endif


                                {{-- <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $trip->vehicle_photo }}" alt="Foto Kendaraan" class="img-circle elevation-2 me-4" width="50" height="50" style="object-fit: cover;">

                                    <div class="ps-1 px-3">
                                        <h6 class="mb-1 fw-bold">{{ $trip->driver_name }}</h6>
                                        <p class="mb-0 text-muted">{{ $trip->license_plate }}</p>
                                    </div>
                                </div> --}}


                                {{-- <p><strong>Status:</strong>
                                    <span class="badge 
                                        @if ($trip->status == 'ongoing') bg-warning
                                        @elseif($trip->status == 'completed') bg-success
                                        @else bg-danger @endif">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </p> --}}
                                {{-- 
                                <p><strong>Lokasi Naik:</strong> {{ $trip->geton_location ?? 'N/A' }}</p>
                                <p><strong>Lokasi Turun:</strong> {{ $trip->getoff_location ?? 'N/A' }}</p>
                                <p><strong>Pickup Time:</strong> {{ $trip->pickup_time ?? '-' }}</p>
                                <p><strong>Arrival Time:</strong> {{ $trip->arrival_time ?? '-' }}</p>
                                <p><strong>Driver:</strong> {{ $trip->driver_name ?? '-' }}</p>
                                <p><strong>Plat Nomor:</strong> {{ $trip->license_plate ?? '-' }}</p>
                                <p><strong>Biaya Perjalanan:</strong> Rp {{ number_format($trip->trip_fare, 0, ',', '.') }}</p> --}}


                                @if ($trip->status === 'ongoing')
                                    <div class="mt-4">
                                        <form id="completeTripForm" action="{{ route('trip.complete', $trip->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="getoff_latitude" id="getoff_latitude">
                                            <input type="hidden" name="getoff_longitude" id="getoff_longitude">
                                            <input type="hidden" name="getoff_location" id="getoff_location">
                                            <input type="hidden" name="getoff_geolocation" id="getoff_geolocation">

                                            <button id="completeTripBtn" class="btn btn-success w-100" type="submit">
                                                🚶 Turun dari Angkot
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    @php
                                        $prefix = Request::segment(1); // Akan mengembalikan 'customer' atau 'partner'
                                    @endphp

                                    <div class="mt-4 d-flex gap-2">
                                        <a href="{{ route($prefix . '.home') }}" class="btn btn-outline-primary w-100">
                                            Kembali Ke Beranda
                                        </a>
                                        {{-- <button class="btn btn-secondary w-100" disabled>
                                            Trip Selesai
                                        </button> --}}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
