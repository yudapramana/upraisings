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
                        <h2 class="text-dark">Bayar Angkot Lebih Mudah untuk
                            <span class="font-bold">Perjalanan Cepat</span> & <span class="font-bold">Nyaman</span> dengan <span class="border-bottom border-dark">AngkotApp</span>

                        </h2>
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
                                    <h2 class="text-dark font-medium">Mitra Angkutan</h2>
                                    <h4 class="text-success">Jadilah Mitra Angkutan & Nikmati Kemudahan Digital!🚖</h4>
                                </div>
                                {{-- <div class="live-box text-center mt-4">
                                <img class="img-fluid" src="{{ asset('/') }}nadist/assets/images/free-demo.jpg" alt="Lite version">
                                <div class="overlay">
                                    <a class="btn btn-danger live-btn" href="../html/ltr/index.html" target="_blank">Live Preview</a>
                                </div>
                            </div> --}}
                                <p class="text-muted mt-5 line-h33 font-16">Bergabunglah sebagai Mitra Angkutan dan rasakan kemudahan nontunai. Pembayaran lebih cepat, transparan, dan tanpa ribet!</p>
                                <p class="p-0 m-0">Keuntungan Menjadi Mitra:</p>
                                <div class="row text-muted">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled listing">
                                            <li>✅ Pembayaran Instan ke akun Anda</li>
                                            <li>✅ Transaksi Aman & Tercatat digital</li>
                                            <li>✅ Tanpa Uang Receh, Tanpa Ribet</li>
                                            <li>✅ Layanan Modern untuk Pelanggan</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-3">
                                    <a href="/register-partner" class="btn btn-custom btn-outline-info btn-lg" target="_blank">Daftar Angkot</a>
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
                                {{-- <div class="live-box text-center mt-4">
                                <img class="img-fluid" src="{{ asset('/') }}nadist/assets/images/pro-demo.jpg" alt="Pro version">
                                <div class="overlay">
                                    <a class="btn btn-danger live-btn" href="http://wrappixel.com/demos/admin-templates/nice-admin/landingpage/" target="_blank">Live Preview</a>
                                </div>
                            </div> --}}
                                <p class="text-muted mt-5 line-h33 font-16">Lupakan repotnya cari uang pas! Dengan AngkotApp, cukup scan QR, bayar instan, dan nikmati perjalanan nyaman tanpa ribet.

                                </p>
                                <p class="p-0 m-0">Kenapa Harus Pakai AngkotApp?
                                </p>
                                <div class="row text-muted">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled listing">
                                            <li>✅ Praktis & Cepat </li>
                                            <li>✅ Aman & Transparan</li>
                                            <li>✅ Tanpa Uang Receh</li>
                                            <li>✅ Diterima di Banyak Angkot</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-3">
                                    <a href="/register-customer" class="btn btn-custom btn-info btn-lg" target="_blank">Mau naik Angkot!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
