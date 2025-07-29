@extends('landing.layouts.layout')
@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .list {
            display: grid;
            grid-gap: 5px;
            padding: 5px 0;
        }

        .list div[class^="item"] {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid rgba(0, 0, 0, .125);
        }

        .list div[class^="section"] {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .list .icon {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .list .icon.up {
            color: #00ff00;
            transform: rotateZ(30deg);
        }

        .list .icon.down {
            color: #ff0000;
            transform: rotateZ(-150deg);
        }

        .list .description {
            color: #7d7d7d;
        }

        .list .signal {
            font-weight: bold;
        }

        .list .signal.positive {
            color: #00ff00;
        }

        .list .signal.negative {
            color: #ff0000;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <!-- Info Saldo -->
                    <div class="col-md-10">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Saldo eWallet Anda</h5>
                                <h3 class="fw-bold text-success">Rp {{ number_format($balance, 2, ',', '.') }}</h3>
                                <p>Status: <span class="badge bg-success">Aktif</span></p>
                                <a href="{{ route('topup') }}" class="btn btn-success btn-sm">Isi Saldo</a>

                                {{-- <a href="{{ $balance >= 7000 ? route('ride') : '#' }}" class="btn btn-primary btn-sm {{ $balance < 7000 ? 'disabled' : '' }}" {{ $balance < 7000 ? 'aria-disabled=true' : '' }}>
                                    Naik Angkot
                                </a> --}}
                                <a href="{{ route('ride') }}" class="btn btn-primary btn-sm">
                                    Naik Angkot
                                </a>
                                <a href="{{ route('transaction.list.customer') }}" class="btn btn-secondary btn-sm">Riwayat Saldo</a>
                                <a href="{{ route('customer.profile') }}" class="btn btn-info btn-sm">Profil</a> <!-- Tambahan Button -->

                                @if ($balance < 7000)
                                    <small class="text-danger d-block mt-1">
                                        Saldo Anda tidak mencukupi maksimum fare (7000). Pembayaran akan dilakukan secara <strong>tunai (cash)</strong> kepada supir angkot.
                                        Silahkan isi Saldo EWallet pada tombol Isi Saldo
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Aktivitas Terbaru -->
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Riwayat Aktivitas Terbaru</h5>
                                <div class="list">
                                    @forelse ($trips as $key => $trip)
                                        <div class="item{{ $key + 1 }} px-2 d-flex justify-content-between align-items-center">
                                            <span style="display: inline-grid; text-align: center;">
                                                <span class="text-muted" style="font-size: 0.75rem;">
                                                    {{ $trip->created_at->format('d M, H:i') }}
                                                </span>
                                                <img src="http://res.cloudinary.com/dezj1x6xp/image/upload/v1750262180/PandanViewMandeh/angkotmax_pkwogi.jpg" alt="Foto Kendaraan" class="img-circle elevation-2 mt-1" width="89" style="object-fit: cover;">
                                            </span>

                                            <div class="pl-3 pt-2 flex-grow-1">
                                                <div>
                                                    <span class="badge border rounded text-dark font-weight-bold" style=" border-bottom-color: {{ $trip->color }} !important; border-bottom-width: 3px !important; font-size: 0.5rem;">
                                                        <i class="fas fa-shuttle-van me-1" style="font-size: 0.7rem;"></i>
                                                        {{ $trip->route_number }}
                                                    </span>
                                                    <span class="badge badge-dark font-weight-bold" style="font-size: 0.6rem;">{{ $trip->license_plate }}</span>
                                                    {{-- <strong class="text-dark" style="font-size: 0.7rem;">{{ $trip->user->name }} </strong> --}}
                                                </div>
                                                @php
                                                    $locgetonparts = explode(',', $trip->geton_location);
                                                    $sliceon = array_slice($locgetonparts, 0, 2);
                                                    $getonAddress = implode(',', $sliceon);

                                                    $locgetoffparts = explode(',', $trip->getoff_location);
                                                    $sliceoff = array_slice($locgetoffparts, 0, 2);
                                                    $getoffAddress = implode(',', $sliceoff);
                                                @endphp
                                                {{-- <strong class="text-dark d-block d-sm-none">{{ $getonAddress ?? '-' }}</strong> --}}
                                                {{-- <strong class="text-dark d-none d-xs-none d-sm-block d-md-none d-lg-none">{{ $formattedLocation ?? '-' }}</strong> --}}
                                                {{-- <strong class="text-dark d-none d-xs-none d-sm-none d-md-block d-lg-block">{{ $trip->getoff_location ?? '-' }}</strong> --}}
                                                {{-- <strong class="text-dark">{{ $trip->user->name }} </strong><br>
                                                naik di <br>
                                                <strong class="text-dark">{{ $getonAddress ?? 'n/a' }}</strong> <br>
                                                turun di <br>
                                                <strong class="text-dark"> {{ $getoffAddress ?? 'n/a' }} </strong>
                                                <br> --}}

                                                <div class="d-flex align-items-center" style="font-size: 0.7rem;">

                                                    <img src="http://res.cloudinary.com/dezj1x6xp/image/upload/v1750247146/PandanViewMandeh/panelarah_angkotapp_k37dlt.jpg" alt="Foto Kendaraan" class="img-circle elevation-2 me-4" width="15" style="object-fit: cover;">

                                                    <div class="ps-1 px-1" style="line-height: 1">
                                                        <small class="text-dark">Naik dari</small><br>
                                                        @php
                                                            $locationParts = explode(',', $trip->geton_location);
                                                            $firstTwo = array_slice($locationParts, 0, 2);
                                                            $formattedLocation = implode(',', $firstTwo);
                                                        @endphp
                                                        <strong class="text-dark">{{ $formattedLocation ?? '-' }}</strong>

                                                        <div class="ms-2 mb-1" style="height: 11px; border-left: 2px #ccc;"></div>

                                                        <small class="text-dark">Turun di - {{ $trip->distance ?? 'n/a' }} km</small><br>
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



                                                @if ($trip->status == 'completed')
                                                    <div class="pt-2" style="font-size: 0.7rem">
                                                        <i class="fas fa-check-circle text-success me-1"></i> Trip Completed
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary mt-1 text-uppercase">
                                                        {{ ucfirst($trip->status) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="section1" style="display: inline-grid; text-align: center;">
                                                <div class="fw-bold mb-1">Rp{{ number_format($trip->trip_fare, 2, ',', '.') }}</div>
                                                <a href="{{ route('trip.show.customer', $trip->id) }}" class="badge badge-success text-white px-2 py-1 mt-5">
                                                    Detail
                                                </a>

                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-3">Belum ada riwayat aktivitas.</div>
                                    @endforelse
                                </div>
                                <a href="{{ route('trip.list') }}" class="btn btn-outline-secondary d-block text-center mt-2">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
