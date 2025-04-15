<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use Illuminate\Http\Request;
use Auth;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\User;

class PaymentController extends Controller
{
    // Menampilkan Form Pembayaran
    public function showPaymentForm()
    {
        return view('customer.payment.pay', [
            'title' => 'Pembayaran Angkot',
        ]);
    }

    // Proses Pembayaran Angkot
    public function processPayment(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required_without:qr_code|exists:ewallets,qrcode_string',
            'qr_code' => 'required_without:mitra_id',
        ]);

        $user = Auth::user();
        $cWallet = EWallet::where('user_id', $user->id)->first();
        $pWallet = EWallet::where('qrcode_string', $request->mitra_id)->first();

        $userPartner = User::find($pWallet->user_id);
        if($userPartner->role != 'partner') {
            return redirect()->route('pay')->with('error', 'Penerima Bukan Mitra Angkot!.');
        }


        // Misalnya tarif angkot = Rp 5000
        $fare = 5000;

        if ($cWallet->balance < $fare) {
            return redirect()->route('pay')->with('error', 'Saldo tidak mencukupi! Silakan isi saldo terlebih dahulu.');
        }

        // Kurangi Saldo Customer
        $cWallet->balance -= $fare;
        $cWallet->save();

        // Simpan transaksi Customer
        $customerTx = Transaction::create([
            'ewallet_id' => $cWallet->id,
            'type' => 'Payment',
            'method' => 'System',
            'operation' => 'minus',
            'last_saldo' => $cWallet->balance,
            'amount' => $fare,
            'description' => "Payment Angkot (ID: {$request->mitra_id})"
        ]);

        // Tambahkan Saldo Mitra
        $pWallet->balance += $fare;
        $pWallet->save();

        // Simpan transaksi
        Transaction::create([
            'ewallet_id' => $pWallet->id,
            'type' => 'Payment',
            'method' => 'System',
            'operation' => 'plus',
            'last_saldo' => $pWallet->balance,
            'amount' => $fare,
            'description' => "Receive Payment (ID: {$user->id})"
        ]);

        // return redirect()->route('pay')->with('success', 'Pembayaran berhasil!');
        // Redirect ke halaman detail transaksi
        return redirect()->route('payment.success', $customerTx->id);

    }

    public function paymentSuccess($id)
    {
        $transaction = Transaction::with('ewallet.user')->findOrFail($id);

        return view('customer.payment.success', compact('transaction'));
    }
}

