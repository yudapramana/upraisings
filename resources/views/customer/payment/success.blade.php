@extends('landing.layouts.layout')

@section('title', 'Info Pembayaran')

@section('styles')
    <style>
        .payment-success-card {
            max-width: 460px;
            margin: auto;
            padding: 25px 20px;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .payment-success-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .payment-table {
            width: 100%;
            font-size: 0.95rem;
        }

        .payment-table th {
            text-align: left;
            padding: 8px;
            color: #666;
            font-weight: 500;
            width: 40%;
        }

        .payment-table td {
            padding: 8px;
            color: #333;
        }

        .amount-positive {
            color: #28a745;
            font-weight: bold;
        }

        .amount-negative {
            color: #dc3545;
            font-weight: bold;
        }

        .proof-image {
            max-width: 100%;
            margin-top: 12px;
            border-radius: 6px;
        }

        @media (max-width: 576px) {
            .payment-success-card {
                padding: 20px 15px;
            }

            .payment-table th,
            .payment-table td {
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="payment-success-card">
            <div class="text-center mb-3">
                <h3 class="text-success">🎉 Info Pembayaran</h3>
                <p class="text-muted mb-0">Detail transaksi Anda:</p>
                <hr class="my-3">
            </div>

            <table class="payment-table">
                <tr>
                    <th>Nama Pengirim</th>
                    <td>{{ $transaction->ewallet->user->name }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $transaction->description }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td class="{{ $transaction->operation == 'plus' ? 'amount-positive' : 'amount-negative' }}">
                        {{ $transaction->operation == 'plus' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Saldo Akhir</th>
                    <td>Rp {{ number_format($transaction->last_saldo, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Metode</th>
                    <td>{{ ucfirst($transaction->method) }}</td>
                </tr>
                <tr>
                    <th>Jenis Operasi</th>
                    <td>{{ ucfirst($transaction->operation) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @if ($transaction->proof_url)
                    <tr>
                        <th>Bukti</th>
                        <td>
                            <img src="{{ asset($transaction->proof_url) }}" alt="Bukti Pembayaran" class="proof-image">
                        </td>
                    </tr>
                @endif
            </table>

            <div class="text-center mt-4">
                <a href="{{ route('customer.home') }}" class="btn btn-primary w-100">⬅️ Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
