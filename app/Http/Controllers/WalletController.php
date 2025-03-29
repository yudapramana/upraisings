<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Menampilkan Form Top-Up
    public function showTopUpForm()
    {
        return view('customer.wallet', [
            'title' => 'Top up eWallet',
        ]);
    }

    // Proses Top-Up
    public function processTopUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:5000000', // Minimal Rp 10.000, maksimal Rp 5.000.000
            'payment_method' => 'required|in:bank_transfer,gopay,ovo,dana',
        ]);

        $wallet = Auth::user()->ewallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        // Simpan transaksi
        Transaction::create([
            'ewallet_id' => $wallet->id,
            'type' => 'Top-up',
            'method' => $request->payment_method,
            'operation' => 'plus',
            'last_saldo' => $wallet->balance,
            'amount' => $request->amount,
            'description' => 'Top-up via ' . $request->payment_method,
        ]);

        return redirect()->route('topup')->with('success', 'Saldo berhasil ditambahkan!');
    }
}
