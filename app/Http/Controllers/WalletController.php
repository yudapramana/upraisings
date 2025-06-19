<?php

namespace App\Http\Controllers;

use App\Models\Bank;
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
            'bank_topup_id' => 'required',
        ]);

        $wallet = Auth::user()->ewallet;
        // $wallet->balance += $request->amount;
        // $wallet->save();

        // Simpan transaksi dengan status "pending"
        $transaction = Transaction::create([
            'ewallet_id' => $wallet->id,
            'type' => 'Top-up',
            'method' => $request->payment_method,
            'operation' => 'plus',
            'last_saldo' => $wallet->balance,
            'amount' => $request->amount,
            'description' => 'Top-up via ' . $request->payment_method,
            'status' => 'pending',
            'bank_topup_id' => $request->bank_topup_id,
        ]);

        $bank = Bank::findOrFail($request->bank_topup_id);

        // Simpan `topup_id` di session agar UI bisa menampilkan upload bukti transfer
        session(['topup_id' => $transaction->id]);
        session(['topup_amount' => $request->amount]);
        session(['topup_method' => $request->payment_method]);
        session(['bank_name' => $bank->bank_name]);
        session(['account_holder' => $bank->account_holder]);
        session(['account_number' => $bank->account_number]);

        return redirect()->route('topup')->with('success', 'Saldo berhasil ditambahkan!');
    }

    public function uploadProof(Request $request, $topupId)
    {
        $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $transaction = Transaction::findOrFail($topupId);
        
        // Simpan file ke storage
        $filePath = $request->file('proof')->store('proofs', 'public');

        // Update transaksi dengan bukti transfer
        $transaction->update([
            'proof'  => $filePath,
            'status' => 'waiting_verification', // Status menunggu verifikasi admin
        ]);

        return redirect()->route('topup')->with('success', 'Bukti transfer berhasil diunggah! Menunggu verifikasi admin.');
    }

    public function submitProof(Request $request, $topupId)
    {
        $request->validate([
            'image_secure_url' => 'required|url',
        ]);

        $transaction = Transaction::findOrFail($topupId);
        $transaction->update([
            'proof_url' => $request->image_secure_url,
            'status'    => 'pending',
        ]);

        session()->forget([
            'topup_id', 
            'topup_amount',
            'topup_method',
            'bank_name',
            'account_holder',
            'account_number'
        ]);
        return redirect()->route('topup')->with('success', 'Bukti transfer berhasil disimpan dan sedang diproses!');
    }

    public function transactions(Request $request)
    {
        $user = Auth::user();
        $ewallet = $user->ewallet;

        if (!$ewallet) {
            return redirect()->back()->with('error', 'Dompet belum tersedia.');
        }

        $query = $ewallet->transactions()->orderByDesc('created_at');

        // Filter tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter jenis transaksi
        if ($request->filled('type')) {
            $query->where('operation', $request->type);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('transaction.partial._list', compact('transactions'))->render();
        }

        return view('transaction.list', compact('transactions'));
    }
}
