@extends('landing.layouts.layout')
@section('title', $title)

@section('styles')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="text-center mb-3">💰 Isi Saldo eWallet</h5>

                                <!-- Notifikasi sukses -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
                                @endif

                                <!-- Form Top-Up -->
                                <form action="{{ route('topup.process') }}" method="POST">
                                    @csrf

                                    <!-- Input Nominal -->
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Nominal (Rp)</label>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Masukkan nominal" required>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pilihan Metode Pembayaran -->
                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="custom-select form-select-sm @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method" required>
                                            <option value="">Pilih metode</option>
                                            <option value="bank_transfer">🏦 Transfer Bank</option>
                                            <option value="gopay">📱 GoPay</option>
                                            <option value="ovo">🔵 OVO</option>
                                            <option value="dana">💳 DANA</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pilihan Bank (Hanya muncul jika Bank Transfer dipilih) -->
                                    <div id="bank_details" class="hidden">
                                        <hr>
                                        <h6>🏦 Pilih Bank Tujuan</h6>
                                        <select class="custom-select form-select-sm @error('bank_name') is-invalid @enderror" name="bank_name" id="bank_name" required>
                                            <option value="">Pilih Bank</option>
                                            <option value="BCA">Bank BCA</option>
                                            <option value="Mandiri">Bank Mandiri</option>
                                            <option value="BNI">Bank BNI</option>
                                            <option value="BRI">Bank BRI</option>
                                            <option value="CIMB">Bank CIMB Niaga</option>
                                        </select>
                                        @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Nomor Rekening & Nama Pemilik -->
                                        <div class="alert alert-info mt-2">
                                            <p class="mb-1">🔢 <strong>Nomor Rekening:</strong> <span id="account_number">-</span></p>
                                            <p class="mb-0">👤 <strong>Nama Akun:</strong> <span id="account_holder">-</span></p>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="{{ route('customer.home') }}" class="btn btn-secondary btn-sm px-3">🔙 Kembali</a>
                                        <button type="submit" class="btn btn-primary btn-sm px-4">✅ Konfirmasi Top-Up</button>
                                    </div>
                                </form>

                                @if (session('topup_id'))
                                    <hr>
                                    <h6 class="text-center">📤 Upload Bukti Transfer</h6>

                                    <!-- Input File (Hidden) -->
                                    <input type="file" id="proof" accept="image/*, application/pdf" style="display: none;">

                                    <!-- Preview dan Tombol Upload -->
                                    <div class="text-center">
                                        <img id="previewImage" class="img-fluid mb-2 hidden" style="max-width: 200px;">
                                        <p id="fileName" class="text-muted hidden"></p>
                                        <button id="uploadBtn" class="btn btn-success w-100">📎 Pilih File</button>
                                        <button id="confirmBtn" class="btn btn-primary w-100 mt-2 hidden">🚀 Unggah ke Cloudinary</button>
                                    </div>

                                    <!-- Input untuk menyimpan URL setelah upload -->
                                    <input type="hidden" id="proof_url" name="proof_url">

                                    <!-- Submit ke Controller -->
                                    <form action="{{ route('topup.submitProof', session('topup_id')) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="image_secure_url" id="image_secure_url">
                                        <button type="submit" id="submitProof" class="btn btn-success w-100 mt-2 hidden">✅ Simpan Bukti Transfer</button>
                                    </form>

                                    <!-- Notifikasi -->
                                    <p id="uploadStatus" class="text-center mt-2"></p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const paymentMethod = document.getElementById("payment_method");
            const bankDetails = document.getElementById("bank_details");
            const bankName = document.getElementById("bank_name");
            const accountNumber = document.getElementById("account_number");
            const accountHolder = document.getElementById("account_holder");

            // Data rekening tujuan berdasarkan bank
            const bankAccounts = {
                "BCA": {
                    number: "123-456-7890",
                    holder: "PT. ABC Indonesia"
                },
                "Mandiri": {
                    number: "987-654-3210",
                    holder: "PT. ABC Mandiri"
                },
                "BNI": {
                    number: "555-333-2221",
                    holder: "PT. ABC BNI"
                },
                "BRI": {
                    number: "444-888-7776",
                    holder: "PT. ABC BRI"
                },
                "CIMB": {
                    number: "999-111-5552",
                    holder: "PT. ABC CIMB"
                }
            };

            // Tampilkan pilihan bank jika metode "Bank Transfer" dipilih
            paymentMethod.addEventListener("change", function() {
                bankDetails.classList.toggle("hidden", paymentMethod.value !== "bank_transfer");
            });

            // Perbarui nomor rekening dan pemilik rekening saat bank dipilih
            bankName.addEventListener("change", function() {
                const selectedBank = bankAccounts[bankName.value] || {
                    number: "-",
                    holder: "-"
                };
                accountNumber.textContent = selectedBank.number;
                accountHolder.textContent = selectedBank.holder;
            });


            // Cloudinary
            const uploadBtn = document.getElementById("uploadBtn");
            const confirmBtn = document.getElementById("confirmBtn");
            const proofInput = document.getElementById("proof");
            const proofUrlInput = document.getElementById("proof_url");
            const imageSecureUrlInput = document.getElementById("image_secure_url");
            const submitProofBtn = document.getElementById("submitProof");
            const previewImage = document.getElementById("previewImage");
            const fileName = document.getElementById("fileName");
            const uploadStatus = document.getElementById("uploadStatus");

            const CLOUDINARY_URL = "https://api.cloudinary.com/v1_1/dmynbnqtt/upload";
            const CLOUDINARY_UPLOAD_PRESET = "angkotapp"; // Dapatkan dari Cloudinary

            // Klik tombol untuk memilih file
            uploadBtn.addEventListener("click", function() {
                proofInput.click();
            });

            // Saat pengguna memilih file
            proofInput.addEventListener("change", function(event) {
                const file = event.target.files[0];
                if (file) {
                    fileName.textContent = `📄 ${file.name}`;
                    fileName.classList.remove("hidden");

                    // Jika gambar, tampilkan preview
                    if (file.type.includes("image")) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove("hidden");
                        };
                        reader.readAsDataURL(file);
                    }

                    confirmBtn.classList.remove("hidden");
                }
            });

            // Saat tombol "Unggah ke Cloudinary" ditekan
            confirmBtn.addEventListener("click", function() {
                const file = proofInput.files[0];
                if (!file) return alert("Pilih file terlebih dahulu!");

                uploadStatus.innerHTML = "⏳ Mengunggah ke Cloudinary...";
                confirmBtn.disabled = true;

                // Gunakan FormData untuk mengunggah file
                const formData = new FormData();
                formData.append("file", file);
                formData.append("upload_preset", CLOUDINARY_UPLOAD_PRESET);

                fetch(CLOUDINARY_URL, {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.secure_url) {
                            proofUrlInput.value = data.secure_url; // Simpan URL di input hidden
                            imageSecureUrlInput.value = data.secure_url; // Untuk dikirim ke server

                            uploadStatus.innerHTML = "✅ Bukti berhasil diunggah!";
                            confirmBtn.classList.add("hidden");
                            submitProofBtn.classList.remove("hidden");
                        } else {
                            throw new Error("Gagal mengunggah");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        uploadStatus.innerHTML = "❌ Gagal mengunggah. Coba lagi!";
                        confirmBtn.disabled = false;
                    });
            });
        });
    </script>
@endsection
