@extends('landing.layouts.layout')
@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .list {
            /* background: #bab9b9; */
            display: grid;
            grid-gap: 5px;
            padding: 5px 0;
            /* height: 180px; */
            /* overflow-y: auto; */
        }

        .list div[class^="item"] {
            display: flex;
            justify-content: space-between;
            /* background: #e3e1e1; */
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
        <!-- ============================================================== -->
        <!-- Demos part -->
        <!-- ============================================================== -->
        <section class="spacer bg-light">

            <div class="container pt-5">
                <div class="row">
                    <!-- Info Saldo -->
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Saldo eWallet Anda</h5>
                                <h3 class="fw-bold text-success">Rp {{ number_format($balance, 2, ',', '.') }}</h3>
                                <p>Status: <span class="badge bg-success">Aktif</span></p>
                                <a href="{{ route('topup') }}" class="btn btn-success btn-sm">Isi Saldo</a>
                                <a href="{{ route('pay') }}" class="btn btn-primary btn-sm">Bayar Angkot</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Transaksi Terbaru -->
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <div class="card shadow-sm">

                            <div class="card-body">
                                <h5 class="card-title">Riwayat Transaksi Terbaru</h5>
                                <div class="list">

                                    @foreach ($transactions as $key => $transaction)
                                        <div class="item{{ $key + 1 }} px-2">
                                            <div class="section1">
                                                @if ($transaction->operation == 'minus')
                                                    <div class="icon down">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                @else
                                                    <div class="icon up">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                @endif
                                                <div class="text">
                                                    <div class="title">{{ $transaction->description }}</div>
                                                    <div class="description">{{ $transaction->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            <div class="section2">
                                                <div class="signal {{ $transaction->operation == 'plus' ? 'positive' : 'negative' }}">{{ $transaction->operation == 'plus' ? '+' : '-' }}</div>
                                                <div class="value">Rp{{ number_format($transaction->amount, 2, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <a href="/transactions" class="btn btn-outline-secondary btn-sm">Lihat Semua</a> --}}
                                <a href="" class="btn btn-outline-secondary d-block text-center mt-2">Lihat Semua</a>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi & Promo -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Notifikasi & Promo</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">🎉 Promo cashback 10% untuk pembayaran angkot!</li>
                                    <li class="list-group-item">🔔 Pembaruan sistem akan dilakukan besok pukul 23:00 WIB.</li>
                                    <li class="list-group-item">🛠️ Fitur transfer saldo akan segera hadir!</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
@endsection
