@extends('landing.layouts.layout')

@section('title', 'Tarik Saldo')

@section('styles')
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            position: relative;
        }

        .btn-max {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #28a745;
            color: white;
            border: none;
            padding: 5px 12px;
            font-size: 0.9rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-max:hover {
            background: #218838;
        }

        .btn-withdraw {
            width: 100%;
        }

        .btn-back {
            margin-top: 10px;
            display: block;
            text-align: center;
        }

        .balance-info {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="spacer bg-light">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 class="fw-bold">Tarik Saldo</h3>
                        <p class="balance-info">Saldo Anda: Rp {{ number_format($wallet_balance, 2, ',', '.') }}</p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-container">
                            @if (empty($user->bank_name) || empty($user->account_number) || empty($user->account_holder))
                                <div class="alert alert-warning text-center">
                                    Anda belum mengisi informasi rekening! <br>
                                    <a href="{{ route('partner.profile') }}" class="btn btn-warning mt-2">Lengkapi Profil</a>
                                </div>
                            @else
                                <form action="{{ route('partner.withdraw.process') }}" method="POST">
                                    @csrf

                                    <!-- Input jumlah tarik saldo -->
                                    <div class="form-group">
                                        <label for="amount">Jumlah Penarikan (Rp)</label>
                                        <div style="position: relative;">
                                            <input type="number" name="amount" id="amount" class="form-control" min="10000" max="{{ $wallet_balance }}" required>
                                            <button type="button" class="btn-max" onclick="setMaxAmount()">Max</button>
                                        </div>
                                    </div>

                                    <!-- Detail Rekening -->
                                    <div class="form-group">
                                        <label>Nama Bank</label>
                                        <input type="text" class="form-control" value="{{ $user->bank_name }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor Rekening</label>
                                        <input type="text" class="form-control" value="{{ $user->account_number }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Nama Pemilik Rekening</label>
                                        <input type="text" class="form-control" value="{{ $user->account_holder }}" disabled>
                                    </div>

                                    <!-- Tombol Tarik Saldo -->
                                    <button type="submit" class="btn btn-success btn-withdraw">Tarik Saldo</button>

                                    <!-- Tombol Kembali -->
                                    <a href="{{ route('partner.home') }}" class="btn btn-outline-secondary btn-back">Kembali ke Beranda</a>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function setMaxAmount() {
            document.getElementById('amount').value = "{{ $wallet_balance }}";
        }
    </script>
@endsection
