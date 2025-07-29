@extends('landing.layouts.layout')

@section('title', 'Profil Pengguna')

@section('styles')
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-save {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-4">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 class="fw-bold">Profil Pengguna</h3>
                    </div>

                    <!-- Foto Kendaraan -->

                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <!-- Notifikasi sukses -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Notifikasi error -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif



                                <form action="{{ route('customer.profile.update') }}" method="POST">
                                    @csrf

                                    <!-- Informasi Pribadi -->
                                    <div class="form-group mb-3">
                                        <label for="name">Nama Pengguna</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="mobile_phone">Nomor HP</label>
                                        <input type="text" name="mobile_phone" id="mobile_phone" class="form-control" value="{{ old('mobile_phone', $user->mobile_phone) }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="city_register">Kota Registrasi</label>
                                        <select class="form-control" id="city_register" name="city_register" required>
                                            <option value="">- Pilih Kab/Kota -</option>
                                            <option value="1309" {{ old('city_register', $user->city_register) == '1309' ? 'selected' : '' }}>Kabupaten Kepulauan Mentawai</option>
                                            <option value="1301" {{ old('city_register', $user->city_register) == '1301' ? 'selected' : '' }}>Kabupaten Pesisir Selatan</option>
                                            <option value="1302" {{ old('city_register', $user->city_register) == '1302' ? 'selected' : '' }}>Kabupaten Solok</option>
                                            <option value="1303" {{ old('city_register', $user->city_register) == '1303' ? 'selected' : '' }}>Kabupaten Sijunjung</option>
                                            <option value="1304" {{ old('city_register', $user->city_register) == '1304' ? 'selected' : '' }}>Kabupaten Tanah Datar</option>
                                            <option value="1305" {{ old('city_register', $user->city_register) == '1305' ? 'selected' : '' }}>Kabupaten Padang Pariaman</option>
                                            <option value="1306" {{ old('city_register', $user->city_register) == '1306' ? 'selected' : '' }}>Kabupaten Agam</option>
                                            <option value="1307" {{ old('city_register', $user->city_register) == '1307' ? 'selected' : '' }}>Kabupaten Lima Puluh Kota</option>
                                            <option value="1308" {{ old('city_register', $user->city_register) == '1308' ? 'selected' : '' }}>Kabupaten Pasaman</option>
                                            <option value="1311" {{ old('city_register', $user->city_register) == '1311' ? 'selected' : '' }}>Kabupaten Solok Selatan</option>
                                            <option value="1310" {{ old('city_register', $user->city_register) == '1310' ? 'selected' : '' }}>Kabupaten Dharmas Raya</option>
                                            <option value="1312" {{ old('city_register', $user->city_register) == '1312' ? 'selected' : '' }}>Kabupaten Pasaman Barat</option>
                                            <option value="1371" {{ old('city_register', $user->city_register) == '1371' ? 'selected' : '' }}>Kota Padang</option>
                                            <option value="1372" {{ old('city_register', $user->city_register) == '1372' ? 'selected' : '' }}>Kota Solok</option>
                                            <option value="1373" {{ old('city_register', $user->city_register) == '1373' ? 'selected' : '' }}>Kota Sawah Lunto</option>
                                            <option value="1374" {{ old('city_register', $user->city_register) == '1374' ? 'selected' : '' }}>Kota Padang Panjang</option>
                                            <option value="1375" {{ old('city_register', $user->city_register) == '1375' ? 'selected' : '' }}>Kota Bukittinggi</option>
                                            <option value="1376" {{ old('city_register', $user->city_register) == '1376' ? 'selected' : '' }}>Kota Payakumbuh</option>
                                            <option value="1377" {{ old('city_register', $user->city_register) == '1377' ? 'selected' : '' }}>Kota Pariaman</option>
                                        </select>
                                    </div>

                                    {{-- <div class="form-group mb-3">
                                    <label>Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                                </div> --}}

                                    {{-- <div class="form-group mb-3">
                                    <label>Status Akun</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->account_status) }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status Akun</label>
                                    <div>
                                        @if ($user->account_status === 'active')
                                            <span class="text-success">✅ Aktif</span>
                                        @else
                                            <span class="text-danger">❌ Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div> --}}

                                    <hr>

                                    <!-- Informasi Rekening Bank -->
                                    {{-- <h5>Informasi Rekening Bank</h5>

                                <div class="form-group mb-3">
                                    <label for="bank_name">Nama Bank</label>
                                    <select class="form-control" id="bank_name" name="bank_name" @readonly(true)>
                                        <option value="">- Pilih Bank -</option>
                                        <option value="BCA" {{ old('bank_name', $user->bank_name) == 'BCA' ? 'selected' : '' }}>BCA (Bank Central Asia)</option>
                                        <option value="BNI" {{ old('bank_name', $user->bank_name) == 'BNI' ? 'selected' : '' }}>BNI (Bank Negara Indonesia)</option>
                                        <option value="BRI" {{ old('bank_name', $user->bank_name) == 'BRI' ? 'selected' : '' }}>BRI (Bank Rakyat Indonesia)</option>
                                        <option value="Mandiri" {{ old('bank_name', $user->bank_name) == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                        <option value="BSI" {{ old('bank_name', $user->bank_name) == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                                        <option value="CIMB Niaga" {{ old('bank_name', $user->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                        <option value="Permata" {{ old('bank_name', $user->bank_name) == 'Permata' ? 'selected' : '' }}>Bank Permata</option>
                                        <option value="Danamon" {{ old('bank_name', $user->bank_name) == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                        <option value="BTN" {{ old('bank_name', $user->bank_name) == 'BTN' ? 'selected' : '' }}>Bank BTN</option>
                                        <option value="BTPN" {{ old('bank_name', $user->bank_name) == 'BTPN' ? 'selected' : '' }}>Bank BTPN</option>
                                        <option value="Maybank" {{ old('bank_name', $user->bank_name) == 'Maybank' ? 'selected' : '' }}>Maybank Indonesia</option>
                                        <option value="OCBC NISP" {{ old('bank_name', $user->bank_name) == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                                        <option value="Bank Mega" {{ old('bank_name', $user->bank_name) == 'Bank Mega' ? 'selected' : '' }}>Bank Mega</option>
                                        <option value="Bank Jago" {{ old('bank_name', $user->bank_name) == 'Bank Jago' ? 'selected' : '' }}>Bank Jago</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="account_number">Nomor Rekening / e-Wallet</label>
                                    <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number', $user->account_number) }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="account_holder">Nama Pemilik Rekening</label>
                                    <input type="text" name="account_holder" id="account_holder" class="form-control" value="{{ old('account_holder', $user->account_holder) }}" readonly>
                                </div> --}}

                                    {{-- <div class="form-group mb-3">
                                    <label>Status Verifikasi Rekening</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->account_verification) }}" readonly>
                                </div> --}}

                                    {{-- <hr> --}}

                                    <!-- Informasi Kendaraan -->
                                    {{-- <h5>Informasi Kendaraan</h5>
                                @if ($user->vehicle)
                                    <div class="form-group mb-3">
                                        <label>Plat Nomor</label>
                                        <input type="text" class="form-control" value="{{ $user->vehicle->license_plate }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Status Kendaraan</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($user->vehicle->status) }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Foto Kendaraan</label><br>
                                        <img src="{{ $user->vehicle->vehicle_photo }}" alt="Foto Kendaraan" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @else
                                    <p class="text-muted">Belum ada kendaraan terdaftar.</p>
                                @endif --}}

                                    {{-- <hr> --}}

                                    <!-- Informasi e-Wallet -->
                                    <h5>e-Wallet</h5>
                                    <div class="form-group mb-3">
                                        <label>Saldo</label>
                                        <input type="text" class="form-control" value="Rp {{ number_format($user->ewallet->balance ?? 0, 2, ',', '.') }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>QR Code String</label>
                                        <input type="text" class="form-control" value="{{ $user->ewallet->qrcode_string ?? '-' }}" readonly>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-save">Simpan Perubahan</button>
                                </form>


                                <a href="{{ route('customer.home') }}" class="btn btn-outline-secondary mt-3 d-block text-center">Kembali ke Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
