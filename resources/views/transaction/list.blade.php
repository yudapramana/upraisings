@extends('landing.layouts.layout')
@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">

                <div class="row justify-content-center">
                    <!-- Info Saldo -->
                    <div class="col-md-10">
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
                                                    @if (Request::segment(1) == 'partner')
                                                        <option value="cash" {{ request('type') == 'cash' ? 'selected' : '' }}>Penerimaan Cash</option>
                                                        <option value="plus" {{ request('type') == 'plus' ? 'selected' : '' }}>Penerimaan Ewallet</option>
                                                        <option value="minus" {{ request('type') == 'minus' ? 'selected' : '' }}>Penarikan</option>
                                                    @else
                                                        <option value="plus" {{ request('type') == 'plus' ? 'selected' : '' }}>Top Up</option>
                                                        <option value="minus" {{ request('type') == 'minus' ? 'selected' : '' }}>Pembayaran EWallet</option>
                                                        <option value="cash" {{ request('type') == 'cash' ? 'selected' : '' }}>Pembayaran Cash</option>
                                                    @endif
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
                            <!-- Daftar Transaksi -->
                            <ul class="list-group shadow-sm" id="transaction-list">
                                @include('transaction.partial._list', ['transactions' => $transactions])
                            </ul>

                            @if ($transactions->hasMorePages())
                                <div class="d-flex justify-content-center mt-3">
                                    <button id="loadMoreBtn" class="btn btn-outline-primary btn-sm">
                                        🔽 Muat Transaksi Sebelumnya
                                    </button>
                                </div>
                            @endif
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


@section('scripts')
    <script>
        let currentPage = 1;
        const loadMoreBtn = document.getElementById('loadMoreBtn');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                currentPage++;
                loadMoreBtn.innerText = '⏳ Memuat...';
                loadMoreBtn.disabled = true;

                const url = new URL(window.location.href);
                url.searchParams.set('page', currentPage);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('transaction-list').insertAdjacentHTML('beforeend', data);
                        loadMoreBtn.innerText = '🔽 Muat Transaksi Sebelumnya';
                        loadMoreBtn.disabled = false;

                        // Sembunyikan tombol kalau sudah halaman terakhir
                        if (!data.includes('list-group-item')) {
                            loadMoreBtn.style.display = 'none';
                        }
                    });
            });
        }
    </script>
@endsection
