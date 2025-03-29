@extends('landing.layouts.layout')
@section('title', $title)

@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- ============================================================== -->
        <!-- Demos part -->
        <!-- ============================================================== -->
    @section('content')
        <div class="content-wrapper">
            <section class="spacer bg-light">
                <div class="container pt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
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
                                        <div class="mb-2">
                                            <label for="amount" class="form-label">Nominal (Rp)</label>
                                            <input type="number" class="form-control form-control-sm @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Masukkan nominal" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Pilihan Metode Pembayaran -->
                                        <div class="mb-3">
                                            <label class="form-label">Metode Pembayaran</label>
                                            <select class="custom-select form-select-sm @error('payment_method') is-invalid @enderror" name="payment_method" required>
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

                                        <!-- Tombol Aksi -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('customer.home') }}" class="btn btn-secondary btn-sm px-3">🔙 Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm px-4">✅ Konfirmasi Top-Up</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
</div>
@endsection
