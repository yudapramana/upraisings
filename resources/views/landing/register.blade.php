@extends('landing.layouts.layout')
@section('title', $title)

@section('styles')
    <style>
        @media (max-width : 480px) {
            .mobile_fix {
                padding: 0;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/gh/priyashpatil/phone-input-by-country@0.0.1/cpi.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- ============================================================== -->
        <!-- Demos part -->
        <!-- ============================================================== -->
        @if ($role == 'partner')
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

                        <div class="col-md-12 mobile_fix">
                            <div class="card card-body">
                                <h4 class="card-title">Formulir Pendaftaran Mitra Angkot</h4>
                                <h5 class="card-subtitle"> Harap diisi dengan data yang valid </h5>

                                <form class="form-horizontal m-t-30 needs-validation" method="POST" action="{{ route('store.partner') }}" enctype="multipart/form-data" novalidate>
                                    @csrf

                                    {{-- Tampilkan Semua Error dalam Satu Div --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li class="small">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- Data User --}}
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input name="nama_lengkap" type="text" class="form-control" placeholder="Cth: Adit Brahmana" value="{{ old('nama_lengkap') }}" required>
                                        <small class="text-muted text-sm">Harap isi dengan nama sesuai KTP termasuk tanda baca dan gelar</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile_phone">Nomor HP aktif</label>
                                        <input type="text" id="mobile_phone" name="mobile_phone" class="form-control" placeholder="Cth: 081122334455" value="{{ old('mobile_phone') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Cth: adityabrahmana@gmail.com" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="city_register">Kota Tempat Mendaftar</label>
                                        <select class="custom-select col-12" id="city_register" name="city_register" required>
                                            <option value="">-Pilih Kab/Kota-</option>
                                            @php
                                                $cities = [
                                                    '1309' => 'Kabupaten Kepulauan Mentawai',
                                                    '1301' => 'Kabupaten Pesisir Selatan',
                                                    '1302' => 'Kabupaten Solok',
                                                    '1303' => 'Kabupaten Sijunjung',
                                                    '1304' => 'Kabupaten Tanah Datar',
                                                    '1305' => 'Kabupaten Padang Pariaman',
                                                    '1306' => 'Kabupaten Agam',
                                                    '1307' => 'Kabupaten Lima Puluh Kota',
                                                    '1308' => 'Kabupaten Pasaman',
                                                    '1311' => 'Kabupaten Solok Selatan',
                                                    '1310' => 'Kabupaten Dharmas Raya',
                                                    '1312' => 'Kabupaten Pasaman Barat',
                                                    '1371' => 'Kota Padang',
                                                    '1372' => 'Kota Solok',
                                                    '1373' => 'Kota Sawah Lunto',
                                                    '1374' => 'Kota Padang Panjang',
                                                    '1375' => 'Kota Bukittinggi',
                                                    '1376' => 'Kota Payakumbuh',
                                                    '1377' => 'Kota Pariaman',
                                                ];
                                            @endphp
                                            @foreach ($cities as $code => $name)
                                                <option value="{{ $code }}" {{ old('city_register') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" name="password" id="password" class="form-control" required>
                                    </div>

                                    <hr>

                                    {{-- Data Rekening Bank --}}
                                    <h5 class="mt-4">Informasi Rekening Bank</h5>
                                    <div class="form-group">
                                        <label for="bank_name">Nama Bank</label>
                                        <select class="form-control" id="bank_name" name="bank_name" required>
                                            <option value="">- Pilih Bank -</option>
                                            <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA (Bank Central Asia)</option>
                                            <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI (Bank Negara Indonesia)</option>
                                            <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>BRI (Bank Rakyat Indonesia)</option>
                                            <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                            <option value="BSI" {{ old('bank_name') == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                                            <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                            <option value="Permata" {{ old('bank_name') == 'Permata' ? 'selected' : '' }}>Bank Permata</option>
                                            <option value="Danamon" {{ old('bank_name') == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                            <option value="BTN" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>Bank BTN</option>
                                            <option value="BTPN" {{ old('bank_name') == 'BTPN' ? 'selected' : '' }}>Bank BTPN</option>
                                            <option value="Maybank" {{ old('bank_name') == 'Maybank' ? 'selected' : '' }}>Maybank Indonesia</option>
                                            <option value="OCBC NISP" {{ old('bank_name') == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                                            <option value="Bank Mega" {{ old('bank_name') == 'Bank Mega' ? 'selected' : '' }}>Bank Mega</option>
                                            <option value="Bank Jago" {{ old('bank_name') == 'Bank Jago' ? 'selected' : '' }}>Bank Jago</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="account_number">Nomor Rekening / e-Wallet</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="account_holder">Nama Pemilik Rekening</label>
                                        <input type="text" name="account_holder" id="account_holder" class="form-control" value="{{ old('account_holder') }}">
                                    </div>

                                    <hr>

                                    {{-- Data Kendaraan --}}
                                    <h5 class="mt-4">Informasi Kendaraan</h5>

                                    <div class="form-group">
                                        <label for="angkot_type_id">Jenis/Trayek Angkot</label>
                                        <select class="custom-select col-12" id="angkot_type_id" name="angkot_type_id" required>
                                            <option value="">-Pilih Trayek-</option>
                                            @foreach ($angkotTypes as $angkot)
                                                <option value="{{ $angkot->id }}" {{ old('angkot_type_id') == $angkot->id ? 'selected' : '' }}>
                                                    {{ $angkot->route_number }} - {{ $angkot->route_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="license_plate">Plat Nomor Kendaraan</label>
                                        <input type="text" id="license_plate" name="license_plate" class="form-control" value="{{ old('license_plate') }}" placeholder="Contoh: BA 1234 QZ" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="vehicle_photo">Foto Angkot</label><br>
                                        <button type="button" id="upload_widget" class="btn btn-outline-primary">Upload Foto Angkot</button>
                                        <input type="hidden" id="vehicle_photo" name="vehicle_photo" value="{{ old('vehicle_photo') }}">
                                        <div id="preview_image" class="mt-2">
                                            @if (old('vehicle_photo'))
                                                <img src="{{ old('vehicle_photo') }}" class="img-fluid mt-2 rounded border" style="max-height: 150px;">
                                            @endif
                                        </div>
                                        <small class="text-muted text-sm">Unggah foto bagian depan angkot dengan jelas</small>
                                    </div>

                                    <button type="submit" class="btn btn-custom btn-info btn-lg btn-block">
                                        Kirim Pendaftaran
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        @if ($role == 'customer')
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

                        <div class="col-md-12 mobile_fix">


                            <div class="card card-body">


                                <div id="registerForm">
                                    <h4 class="card-title">Masuk atau daftar hanya dalam beberapa langkah mudah.</h4>
                                    {{-- <form class="form-horizontal m-t-30 needs-validation" method="POST" action="{{ route('store.customer') }}" novalidate> --}}
                                    <!-- Form -->
                                    <form id="customerForm" class="form-horizontal m-t-30 needs-validation" novalidate>
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control" placeholder="Cth: Adit Brahmana" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_phone">Nomor Handphone</label>
                                            <div class="cpi-input">
                                                <div class="input-group mb-3 border rounded">
                                                    <button class="btn btn-light dropdown-toggle d-flex align-items-center cpi-drop" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="me-1">ID</span>
                                                    </button>
                                                    <span class="input-group-text bg-white text-muted cpi-ext-txt">+62</span>
                                                    <input id="mobile_phone" name="mobile_phone" type="text" class="form-control phone-input flex-shrink-1" style="outline: none;" pattern="[0-9]+" required minlength="10" maxlength="12" placeholder="81x-xxx-xxx">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Cth: adityabrahmana@gmail.com" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" class="form-control" required="">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Ketentuan Penggunaan</label>
                                            <div class="col-xs-9">
                                                <div style="border: 1px solid #e5e5e5; height: 100px; overflow: auto; padding: 10px;">
                                                    <p><strong>Syarat dan Ketentuan Pendaftaran AngkotApp</strong></p>
                                                    <p><strong>1. Data Akurat:</strong> Pengguna wajib mengisi data pendaftaran dengan benar.</p>
                                                    <p><strong>2. Nomor HP & Email Aktif:</strong> Pastikan nomor HP dan email masih aktif.</p>
                                                    <p><strong>3. Keamanan Akun:</strong> Pengguna bertanggung jawab atas keamanan akun.</p>
                                                    <p><strong>4. Penggunaan yang Sah:</strong> Akun yang terdaftar hanya boleh digunakan sesuai ketentuan.</p>
                                                    <p><strong>5. Pelanggaran & Sanksi:</strong> AngkotApp berhak menonaktifkan akun yang melanggar.</p>
                                                    <p class="text-danger font-weight-bold">Dengan melakukan pendaftaran, pengguna menyetujui syarat dan ketentuan.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                                            <label class="form-check-label" for="agree">Saya menyetujui syarat dan ketentuan</label>
                                            <div class="invalid-feedback">Anda harus menyetujui syarat dan ketentuan sebelum melanjutkan.</div>
                                        </div>

                                        <button type="submit" id="submitBtn" class="btn btn-custom btn-info btn-lg btn-block">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                                            <span id="btnText">Lanjut Daftar</span>
                                        </button>
                                    </form>

                                    <!-- Notification Area -->
                                    <div id="notification" class="mt-3"></div>

                                </div>

                                <!-- NOTIFICATION AREA (Hidden Initially) -->
                                <div id="successMessage" class="text-center" style="display: none;">
                                    <h3 class="text-success font-weight-bold">🎉 Selamat! 🎉</h3>
                                    <p class="text-dark">Kamu telah berhasil mendaftar di <strong>AngkotApp</strong>.</p>
                                    <button class="btn btn-primary" onclick="window.location.replace('/customer');">ke Beranda</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/priyashpatil/phone-input-by-country@0.0.1/cpi.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        document.getElementById('customerForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            // Get elements
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');

            // Disable tombol & tampilkan spinner
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.innerText = 'Memproses...';

            // Get form values
            let nama_lengkap = document.getElementById('nama_lengkap').value;
            let mobile_phone = document.getElementById('mobile_phone').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let agree = document.getElementById('agree').checked;

            if (!agree) {
                document.getElementById('notification').innerHTML = '<div class="alert alert-danger">Anda harus menyetujui syarat dan ketentuan.</div>';
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                btnText.innerText = 'Lanjut Daftar';
                return;
            }

            let requestData = {
                nama_lengkap: nama_lengkap,
                mobile_phone: '0' + mobile_phone,
                email: email,
                password: password
            };

            try {
                let response = await fetch('/store-customer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(requestData)
                });

                let result = await response.json();

                if (response.ok) {
                    // Simulasi pengiriman ke backend (gunakan AJAX di produksi)
                    document.getElementById('notification').innerHTML = '<div class="alert alert-success">Registrasi berhasil! Silakan login.</div>';
                    setTimeout(function() {
                        // Sembunyikan formulir
                        document.getElementById("registerForm").style.display = "none";
                        // Tampilkan pesan sukses
                        document.getElementById("successMessage").style.display = "block";
                    }, 500);
                    // document.getElementById('customerForm').reset();
                } else {
                    // Menampilkan error validasi
                    if (result.errors) {
                        let errorMessages = Object.values(result.errors).flat().join("<br>");
                        document.getElementById('notification').innerHTML = `<div class="alert alert-danger">${errorMessages}</div>`;
                    } else {
                        document.getElementById('notification').innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
                    }
                }
            } catch (error) {
                document.getElementById('notification').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Coba lagi.</div>';
            }

            // Aktifkan kembali tombol dan sembunyikan spinner
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
            btnText.innerText = 'Lanjut Daftar';
        });
    </script>


    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
    {{-- folder: 'angkot_photos',
            sources: ['local', 'camera', 'url'], --}}
    <script type="text/javascript">
        var myWidget = cloudinary.createUploadWidget({
            cloudName: 'dmynbnqtt', // Ganti dengan cloud name kamu
            uploadPreset: 'angkotapp', // Ganti dengan upload preset kamu
            multiple: false,
            cropping: false,
            maxFileSize: 2000000,
            clientAllowedFormats: ["jpg", "jpeg", "png"],
            maxImageWidth: 1600
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                console.log("Foto berhasil diupload: ", result.info);
                document.getElementById("vehicle_photo").value = result.info.secure_url;
                document.getElementById("preview_image").innerHTML =
                    `<img src="${result.info.secure_url}" class="img-fluid mt-2 rounded border" style="max-height: 150px;">`;
            }
        });

        document.getElementById("upload_widget").addEventListener("click", function() {
            myWidget.open();
        }, false);
    </script>



@endsection
