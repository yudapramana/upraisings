@extends('landing.layouts.layout')
@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">

                <div class="row justify-content-center">
                    <!-- Info Saldo -->
                    <div class="col-md-6">
                        <h5 class="text-center mb-3">📄 Riwayat Transaksi</h5>

                        <!-- Notifikasi -->
                        @if (session('success'))
                            <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
                        @endif

                        <!-- Filter Form -->
                        @php
                            $prefix = Request::segment(1); // Akan mengembalikan 'customer' atau 'partner'
                        @endphp
                        <form action="{{ route('transaction.list.' . $prefix) }}" method="GET" class="row g-2 mb-3">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <label for="start_date" class="form-label mb-0 small">Tanggal Mulai</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="end_date" class="form-label mb-0 small">Tanggal Selesai</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end">
                                            <div class="me-md-3 w-100">
                                                <label for="type" class="form-label mb-0 small">Jenis Transaksi</label>
                                                <select name="type" id="type" class="form-select form-select-sm form-control form-control-sm">
                                                    <option value="">Semua Jenis</option>
                                                    <option value="plus" {{ request('type') == 'plus' ? 'selected' : '' }}>Penerimaan</option>
                                                    <option value="minus" {{ request('type') == 'minus' ? 'selected' : '' }}>Penarikan</option>
                                                </select>
                                            </div>

                                            <div class="mt-2 mt-md-0">
                                                <label class="form-label invisible d-none d-md-block">Filter</label> {{-- Spacer --}}
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    🔍 Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @php
                            $prefix = Request::segment(1); // Akan mengembalikan 'customer' atau 'partner'
                        @endphp


                        <!-- Transaksi List -->
                        @if ($transactions->count() > 0)
                            <ul class="list-group shadow-sm">
                                @foreach ($transactions as $trx)
                                    <li class="list-group-item mb-2 rounded border-light shadow-sm">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>
                                                    @if ($prefix == 'customer')
                                                        {{ $trx->operation == 'plus' ? '⬆️ Top-up' : '⬇️ Pembayaran' }}
                                                    @else
                                                        {{ $trx->operation == 'plus' ? '⬆️ Penerimaan' : '⬇️ Penarikan' }}
                                                    @endif
                                                </strong>
                                                <br>
                                                <small class="text-muted">{{ $trx->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold {{ $trx->operation == 'plus' ? 'text-success' : 'text-danger' }}">
                                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                                </span>
                                                <br>
                                                <span class="badge bg-{{ $trx->status == 'completed' ? 'success' : ($trx->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                                    {{ ucfirst($trx->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        @if ($trx->description)
                                            <p class="mt-2 mb-0 small text-muted">{{ $trx->description }}</p>
                                        @endif
                                        @if ($trx->proof_url)
                                            <a href="{{ $trx->proof_url }}" target="_blank" class="d-block mt-2 small text-primary">
                                                🔗 Lihat Bukti Dukung
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info text-center">
                                Belum ada transaksi ditemukan.
                            </div>
                        @endif

                        <a href="{{ route($prefix . '.home') }}" class="btn btn-secondary d-block text-center mt-2" style="bakcground-color: #fff">🔙 Kembali</a>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
