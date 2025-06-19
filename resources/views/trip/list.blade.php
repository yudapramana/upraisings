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

                                @if ($trips->count() > 0)
                                    <div class="list" id="trip-list">
                                        @include('trip.partials._list', ['trips' => $trips])
                                    </div>

                                    @if ($trips->hasMorePages())
                                        <div class="text-center mt-3">
                                            <button id="loadMoreBtn" class="btn btn-outline-primary btn-sm">🔽 Muat Trip Sebelumnya</button>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info text-center">
                                        Belum ada riwayat aktivitas.
                                    </div>
                                @endif

                                @php
                                    $prefix = Request::segment(1); // Akan mengembalikan 'customer' atau 'partner'
                                @endphp
                                <a href="{{ route($prefix . '.home') }}" class="btn btn-outline-secondary d-block text-center mt-2">🔙 Kembali</a>
                            </div>
                        </div>
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
                loadMoreBtn.disabled = true;
                loadMoreBtn.innerText = '⏳ Memuat...';

                const url = new URL(window.location.href);
                url.searchParams.set('page', currentPage);

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(response => response.text())
                    .then(data => {
                        document.getElementById('trip-list').insertAdjacentHTML('beforeend', data);

                        // Jika tidak ada lagi trip baru, sembunyikan tombol
                        if (!data.includes('item')) {
                            loadMoreBtn.style.display = 'none';
                        } else {
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.innerText = '🔽 Muat Trip Sebelumnya';
                        }
                    });
            });
        }
    </script>
@endsection
