@extends('landing.layouts.layout')
@section('title', 'Riwayat Trip')

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
                    <div class="col-md-6">
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
                                                @php
                                                    $locationParts = explode(',', $trip->getoff_location);
                                                    $firstTwo = array_slice($locationParts, 0, 3);
                                                    $formattedLocation = implode(',', $firstTwo);
                                                @endphp
                                                <strong class="text-dark d-block">{{ $formattedLocation ?? '-' }}</strong>

                                                @if ($trip->status == 'completed')
                                                    <div class="pt-3">
                                                        <i class="fas fa-check-circle text-success me-1"></i> Trip Completed
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary mt-1 text-uppercase">
                                                        {{ ucfirst($trip->status) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div style="display: inline-grid; text-align: center;">
                                                <div class="fw-bold mb-1">Rp{{ number_format($trip->trip_fare, 2, ',', '.') }}</div>
                                                <a href="{{ route('trip.show', $trip->id) }}" class="badge badge-success text-white px-2 py-1 mt-5">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-3">Belum ada riwayat aktivitas.</div>
                                    @endforelse
                                </div>
                                <a href="{{ route('customer.home') }}" class="btn btn-outline-secondary d-block text-center mt-2">🔙 Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
