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
                                        <input type="text" class="form-control form-control-sm @error('mitra_id') is-invalid @enderror" name="mitra_id" id="mitra_id" placeholder="Masukkan ID Mitra" required>
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

                                    <!-- Tempat Scanner QR -->
                                    <div id="qr-scanner-container" class="mt-3 text-center" style="display: none;">
                                        <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>
                                        <button type="button" class="btn btn-danger btn-sm mt-2" id="stopScan">❌ Stop Scan</button>
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

    <!-- QR Scanner Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script>
        let scanner;
        document.getElementById('scanQR').addEventListener('click', function() {
            let scannerContainer = document.getElementById('qr-scanner-container');
            scannerContainer.style.display = 'block';

            scanner = new Html5Qrcode("reader");
            scanner.start({
                    facingMode: "environment"
                }, // Use back camera if available
                {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                },
                (decodedText) => {
                    document.getElementById('qr_code').value = decodedText;
                    document.getElementById('mitra_id').value = decodedText;
                    stopScanning();
                },
                (errorMessage) => {
                    console.warn("QR scan error:", errorMessage);
                }
            ).catch(err => {
                console.error(err);
                alert("Gagal mengakses kamera. Pastikan izin kamera diaktifkan.");
            });
        });

        document.getElementById('stopScan').addEventListener('click', stopScanning);

        function stopScanning() {
            if (scanner) {
                scanner.stop().then(() => {
                    document.getElementById('qr-scanner-container').style.display = 'none';
                }).catch(err => console.error("Error stopping scanner:", err));
            }
        }
    </script>

@endsection
