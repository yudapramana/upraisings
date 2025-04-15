@extends('landing.layouts.layout')
@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <h5 class="text-center mb-3">📄 Riwayat Transaksi</h5>

                <!-- Notifikasi -->
                @if (session('success'))
                    <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
                @endif

                <!-- Filter Form -->
                <form action="{{ route('transaction.list') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-6">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-6">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-6">
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Semua Jenis</option>
                            <option value="plus" {{ request('type') == 'plus' ? 'selected' : '' }}>Top-up</option>
                            <option value="minus" {{ request('type') == 'minus' ? 'selected' : '' }}>Pembayaran</option>
                        </select>
                    </div>
                    <div class="col-6 d-grid">
                        <button type="submit" class="btn btn-primary btn-sm">🔍 Filter</button>
                    </div>
                </form>

                <!-- Transaksi List -->
                @if ($transactions->count() > 0)
                    <ul class="list-group shadow-sm">
                        @foreach ($transactions as $trx)
                            <li class="list-group-item mb-2 rounded border-light shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>
                                            {{ $trx->operation == 'plus' ? '⬆️ Top-up' : '⬇️ Pembayaran' }}
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
            </div>
        </section>
    </div>
@endsection
