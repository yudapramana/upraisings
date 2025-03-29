@extends('landing.layouts.layout')

@section('title', 'Profil Mitra')

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
            <div class="container pt-5">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 class="fw-bold">Profil Mitra</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-container">
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

                            <form action="{{ route('partner.profile.update') }}" method="POST">
                                @csrf

                                <!-- Informasi Pribadi -->
                                <div class="form-group mb-3">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="mobile_phone">Nomor HP</label>
                                    <input type="text" name="mobile_phone" id="mobile_phone" class="form-control" value="{{ old('mobile_phone', $user->mobile_phone) }}">
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

                                <hr>

                                <!-- Informasi Rekening Bank -->
                                <h5>Informasi Rekening Bank</h5>

                                <div class="form-group mb-3">
                                    <label for="bank_name">Nama Bank</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ old('bank_name', $user->bank_name) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="account_number">Nomor Rekening / e-Wallet</label>
                                    <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number', $user->account_number) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="account_holder">Nama Pemilik Rekening</label>
                                    <input type="text" name="account_holder" id="account_holder" class="form-control" value="{{ old('account_holder', $user->account_holder) }}">
                                </div>

                                <button type="submit" class="btn btn-success btn-save">Simpan Perubahan</button>
                            </form>

                            <a href="{{ route('partner.home') }}" class="btn btn-outline-secondary mt-3 d-block text-center">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
