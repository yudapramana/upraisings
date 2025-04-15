@extends('landing.layouts.layout')
@section('title', $title)

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="text-center mb-3">🚕 Pembayaran Angkot</h5>

                                <!-- Notifikasi -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
                                @endif

                                <!-- Form Pembayaran -->
                                <form action="{{ route('pay.process') }}" method="POST">
                                    @csrf

                                    <!-- Input ID Mitra -->
                                    <div class="mb-2">
                                        <label for="mitra_id" class="form-label">ID Mitra Angkot</label>
                                        <input readonly="readonly" type="text" class="form-control form-control-sm @error('mitra_id') is-invalid @enderror" name="mitra_id" id="mitra_id" placeholder="Masukkan ID Mitra" required>
                                        @error('mitra_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- ATAU Scan QR Code -->
                                    <div class="text-center my-2">
                                        <small class="text-muted">Atau</small>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="scanQR">
                                            📷 Scan QR Angkot
                                        </button>
                                        <input type="hidden" name="qr_code" id="qr_code">
                                    </div>

                                    <!-- Info Tarif -->
                                    <div class="mt-3 text-center">
                                        <h6 class="mb-1">Tarif Angkot</h6>
                                        <p class="fw-bold text-danger">Rp 5.000</p>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('customer.home') }}" class="btn btn-secondary btn-sm px-3">🔙 Kembali</a>
                                        <button type="submit" class="btn btn-primary btn-sm px-4">✅ Bayar Sekarang</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Scan QR Code (Menggunakan Scanner JS) -->
    <script>
        document.getElementById('scanQR').addEventListener('click', function() {
            let qrValue = prompt("Masukkan QR Code (simulasi)");
            if (qrValue) {
                document.getElementById('qr_code').value = qrValue;
                document.getElementById('mitra_id').value = qrValue;
            }
        });
    </script>

@endsection
