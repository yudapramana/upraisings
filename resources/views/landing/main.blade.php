@extends('landing.layouts.layout')
@section('title', $title)


@section('content')
    <div class="content-wrapper">
        <!-- ============================================================== -->
        <!-- Demos part -->
        <!-- ============================================================== -->
        <section class="spacer bg-light">
            <div class="container">
                <div class="row justify-content-md-center pt-5">
                    <div class="col-md-9 text-center">
                        <h2 class="text-dark">
                            Bayar Angkot Lebih Mudah untuk
                            <span class="font-bold">Perjalanan Cepat</span> &amp; <span class="font-bold">Nyaman</span> dengan <span class="border-bottom border-dark">AngkotApp</span>
                        </h2>

                        <div class="mt-4">
                            @auth
                                @php
                                    $role = auth()->user()->role === 'director' ? 'admin' : auth()->user()->role;
                                @endphp
                                <a href="{{ route($role . '.home') }}" class="btn btn-success btn-lg px-4">Ke-Beranda Aplikasi</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Login Sekarang</a>

                                <div class="alert alert-warning mt-3 mb-0" role="alert" style="font-size: 0.95rem;">
                                    <strong>Belum punya akun?</strong> Cukup <strong>scan QR Code</strong> yang ada di angkot untuk langsung memulai perjalanan tanpa login!
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="row py-5">
                    <!-- ============================================================== -->
                    <!-- Lite Demo -->
                    <!-- ============================================================== -->
                    <div class="col-md-6">
                        <div class="card p-2 mr-1">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h2 class="text-dark font-medium">Daftarkan Angkutan Kota</h2>
                                    <h4 class="text-success">Ikut Yuk jadi Angkot yang Digital! 🚖</h4>
                                </div>

                                <p class="text-muted mt-5 line-h33 font-16">Gabung jadi Pengemudi Angkutan. Transaksi bisa cash maupun spesial nontunai cepat, transparan, dan tanpa ribet!</p>
                                <p class="p-0 m-0">Keuntungan Bergabung:</p>
                                <div class="row text-muted">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled listing">
                                            <li>✅ Pembayaran instan langsung ke akun Anda</li>
                                            <li>✅ Transaksi aman dan tercatat secara digital</li>
                                            <li>✅ Tanpa uang receh, tanpa ribet</li>
                                            <li>✅ Layanan modern untuk penumpang</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-3">
                                    <a href="/register-partner" class="btn btn-custom btn-outline-info btn-lg">Daftar Angkot</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Pro Demo -->
                    <!-- ============================================================== -->
                    <div class="col-md-6">
                        <div class="card pro-demo p-2 ml-1">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h2 class="text-info font-medium">Ayuk Ngangkot!</h2>
                                    <h4 class="text-dark">Naik Angkot Jadi Lebih Mudah & Praktis! 🚖📲</h4>
                                </div>

                                <p class="text-muted mt-5 line-h33 font-16">Lupakan repotnya cari uang pas! Dengan AngkotApp, cukup scan QR, bayar berdasar jarak, dan nikmati perjalanan tanpa ribet.

                                </p>
                                <p class="p-0 m-0">Kenapa Harus Pakai AngkotApp?
                                </p>
                                <div class="row text-muted">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled listing">
                                            <li>✅ Praktis & Cepat </li>
                                            <li>✅ Aman & Transparan</li>
                                            <li>✅ Biaya terukur dan Tanpa Uang Receh bagi yang login</li>
                                            <li>✅ Diterima di Banyak Angkot</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-3">
                                    <a href="/register-customer" class="btn btn-custom btn-info btn-lg">Daftar untuk Bayar Angkot Online</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
