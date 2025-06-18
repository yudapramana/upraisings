<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $driver = Auth::user();
        $wallet = $driver->ewallet;
        $balance = $wallet->balance;

        $transactions = Transaction::where('ewallet_id', $wallet->id)
                        ->where('status', 'completed')
                        ->orderBy('created_at', 'desc')
                        ->take(3)->get();

        // Hitung total pendapatan hari ini, minggu ini, dan bulan ini
        $totalToday = Transaction::where('ewallet_id', $wallet->id)
                            ->whereDate('created_at', today())
                            ->where('operation', 'plus')
                            ->where('status', 'completed')
                            ->sum('amount');
                    
        $totalWeek = Transaction::where('ewallet_id', $wallet->id)
                            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                            ->where('operation', 'plus')
                            ->where('status', 'completed')
                            ->sum('amount');

        $totalMonth = Transaction::where('ewallet_id', $wallet->id)
                            ->whereMonth('created_at', now()->month)
                            ->where('operation', 'plus')
                            ->where('status', 'completed')
                            ->sum('amount');


        return view('partner.main', [
            'title' => 'Dashboard Angkot',
            'balance' => $balance,
            'transactions' => $transactions,
            'driver' => $driver,
            'wallet' => $wallet,
            'totalToday' => $totalToday,
            'totalWeek' => $totalWeek,
            'totalMonth' => $totalMonth,
        ]);
    }

    public function withdraw()
    {
        $user = Auth::user();
        $wallet = $user->ewallet;
        $wallet_balance = $wallet->balance;
        return view('partner.withdraw', compact('user', 'wallet_balance'));
    }

    public function withdrawProcess(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->ewallet;

         // Check if there's already a pending withdrawal
        $pendingWithdrawal = Transaction::where('ewallet_id', $wallet->id)
                                ->where('type', 'Withdrawal')
                                ->where('status', 'pending')
                                ->exists();

        if ($pendingWithdrawal) {
            return redirect()->route('partner.withdraw')->with('error', 'Anda tidak dapat melakukan penarikan karena masih ada transaksi penarikan yang sedang diproses.');
        }

        // Validasi input
        $request->validate([
            'amount' => "required|numeric|min:10000|max:$wallet->balance",
        ]);

        // Simpan transaksi penarikan
        Transaction::create([
            'ewallet_id' => $wallet->id,
            'type' => 'Withdrawal',
            'method' => 'bank_transfer',
            'operation' => 'minus',
            'last_saldo' => $wallet->balance,
            'amount' => $request->amount,
            'description' => 'Withdraw via bank transfer to: ' . $user->bank_name . ' a.n.' . $user->account_holder,
            'status' => 'pending',
        ]);

        return redirect()->route('partner.withdraw')->with('success', 'Permintaan tarik saldo sedang diproses!');
    }


    public function showQr()
    {
        $user = Auth::user();
        $wallet = $user->ewallet;

        // String unik, misalnya pakai UUID, ID, atau apa pun yang kamu mau
        $uniqueData = $wallet->qrcode_string; // contoh kombinasi

        $qrCode = QrCode::size(300)->generate($uniqueData);

        return view('partner.qrcode', compact('qrCode', 'user'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
