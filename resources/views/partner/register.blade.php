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
                                <h4 class="card-title">Formulir Pendaftaran Angkot</h4>
                                <h5 class="card-subtitle"> Harap diisi dengan data yang valid </h5>
                                <form class="form-horizontal m-t-30 needs-validation" method="POST" action="{{ route('store.partner') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input name="nama_lengkap" type="text" class="form-control" placeholder="Cth: Adit Brahmana" required="">
                                        <small class="text-muted text-sm">Harap isi dengan nama sesuai KTP termasuk tanda baca dan gelar</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile_phone">Nomor HP aktif</label>
                                        <input type="text" id="mobile_phone" name="mobile_phone" class="form-control" placeholder="Cth: 081122334455" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Cth: adityabrahmana@gmai.com" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="city_register">Kota Tempat Mendaftar</label>
                                        <select class="custom-select col-12" id="city_register" name="city_register" required="">
                                            <option value="">-Pilih Kab/Kota-</option>
                                            <option value="1309">Kabupaten Kepulauan Mentawai</option>
                                            <option value="1301">Kabupaten Pesisir Selatan</option>
                                            <option value="1302">Kabupaten Solok</option>
                                            <option value="1303">Kabupaten Sijunjung</option>
                                            <option value="1304">Kabupaten Tanah Datar</option>
                                            <option value="1305">Kabupaten Padang Pariaman</option>
                                            <option value="1306">Kabupaten Agam</option>
                                            <option value="1307">Kabupaten Lima Puluh Kota</option>
                                            <option value="1308">Kabupaten Pasaman</option>
                                            <option value="1311">Kabupaten Solok Selatan</option>
                                            <option value="1310">Kabupaten Dharmas Raya</option>
                                            <option value="1312">Kabupaten Pasaman Barat</option>
                                            <option value="1371">Kota Padang</option>
                                            <option value="1372">Kota Solok</option>
                                            <option value="1373">Kota Sawah Lunto</option>
                                            <option value="1374">Kota Padang Panjang</option>
                                            <option value="1375">Kota Bukittinggi</option>
                                            <option value="1376">Kota Payakumbuh</option>
                                            <option value="1377">Kota Pariaman</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required="">
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

                                        <button type="submit" class="btn btn-custom btn-info btn-lg btn-block">
                                            Lanjut Daftar
                                        </button>
                                    </form>

                                    <!-- Notification Area -->
                                    <div id="notification" class="mt-3"></div>

                                </div>

                                <!-- NOTIFICATION AREA (Hidden Initially) -->
                                <div id="successMessage" class="text-center" style="display: none;">
                                    <h3 class="text-success font-weight-bold">🎉 Selamat! 🎉</h3>
                                    <p class="text-dark">Kamu telah berhasil mendaftar di <strong>AngkotApp</strong>.</p>
                                    <button class="btn btn-primary" onclick="window.location.reload();">Kembali</button>
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

            // Get form values
            let nama_lengkap = document.getElementById('nama_lengkap').value;
            let mobile_phone = document.getElementById('mobile_phone').value;
            let email = document.getElementById('email').value;
            let agree = document.getElementById('agree').checked;

            if (!agree) {
                document.getElementById('notification').innerHTML = '<div class="alert alert-danger">Anda harus menyetujui syarat dan ketentuan.</div>';
                return;
            }

            let requestData = {
                nama_lengkap: nama_lengkap,
                mobile_phone: '+62' + mobile_phone,
                email: email
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
        });
    </script>


@endsection
