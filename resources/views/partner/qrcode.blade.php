@extends('landing.layouts.layout')

@section('title', 'QR Code Angkot')

@section('styles')
    <style>
        .qr-container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
            text-align: center;
        }

        .mitra-info {
            background: #f1f3f5;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: left;
        }

        .mitra-info h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .mitra-info .row-info {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .mitra-info .row-info span {
            font-weight: 500;
        }

        .qr-code {
            padding: 12px;
            background: #f8f9fa;
            display: inline-block;
            border-radius: 10px;
        }

        .btn-print {
            margin-top: 20px;
        }

        @media print {

            .btn-print,
            .btn-back {
                display: none !important;
            }

            footer {
                display: none !important;
            }

            .qr-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="qr-container">
                    <h4 class="fw-bold mb-4">QR Code Angkot</h4>

                    <div class="mitra-info">
                        <h5>Informasi Angkot</h5>
                        <div class="row-info">
                            <div>Nama</div>
                            <span>{{ $user->name }}</span>
                        </div>
                        {{-- <div class="row-info">
                            <div>ID Angkot</div>
                            <span>{{ $user->ewallet->qrcode_string }}</span>
                        </div> --}}
                        <div class="row-info">
                            <div>Plat Nomor</div>
                            <span>{{ $user->vehicle->license_plate }}</span>
                        </div>
                        <div class="row-info">
                            <div>Trayek</div>
                            <span>{{ $user->vehicle->angkotType->route_number }}</span>
                        </div>
                        <div class="row-info">
                            <div>Rute</div>
                            <span class="text-small" style="font-size: 0.85rem;">{{ $user->vehicle->angkotType->route_name }}</span>
                        </div>
                        <div class="row-info">
                            <div>No. HP</div>
                            <span>{{ $user->mobile_phone ?? '-' }}</span>
                        </div>

                    </div>

                    <div class="qr-code mb-4">
                        {!! $qrCode !!}
                    </div>

                    <button class="btn btn-primary btn-print" onclick="window.print()">🖨️ Cetak QR Code</button>

                    <a href="{{ route('partner.home') }}" class="btn btn-outline-secondary mt-3 btn-back d-block">
                        ← Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
