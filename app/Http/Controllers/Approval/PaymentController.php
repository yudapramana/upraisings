<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Ewallet;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function topup()
    {
        $transactions = Transaction::with('ewallet.user')
            ->where('operation', 'plus')
            ->where('method', '!=', 'system')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        // return view('dashboard.payment.verification', compact('transactions'));

        $params = [
            "titlePages"    => 'Topup to be verified',
            "transactions"         => $transactions,
        ];

        return view('dashboard.payment.topup', $params);
    }

    public function withdraw()
    {
        $transactions = Transaction::with('ewallet.user')
            ->where('operation', 'minus') // berbeda dari topup yang 'plus'
            ->where('method', '!=', 'system')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $params = [
            "titlePages" => 'Withdraw to be verified',
            "transactions" => $transactions,
        ];

        return view('dashboard.payment.withdraw', $params);
    }

    public function verifyTopup($id, Request $request)
    {
        $transaction = Transaction::findOrFail($id);
        $ewallet = $transaction->ewallet;

        if ($request->action == 'approve') {
            $transaction->status = 'completed';
            $ewallet->balance += $transaction->amount;
        } else {
            $transaction->status = 'failed';
        }

        $transaction->save();
        $ewallet->save();

        return redirect()->back()->with('success', 'Transaksi berhasil diverifikasi.');
    }

    public function verifyWithdraw($id, Request $request)
    {
        $transaction = Transaction::findOrFail($id);
        $ewallet = $transaction->ewallet;

        if ($request->action == 'approve') {
            // Pastikan saldo cukup sebelum mengurangi
            if ($ewallet->balance >= $transaction->amount) {
                $transaction->status = 'completed';
                $ewallet->balance -= $transaction->amount;
            } else {
                return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk menyetujui penarikan.');
            }
        } else {
            $transaction->status = 'failed';
        }

        $transaction->save();
        $ewallet->save();

        return redirect()->back()->with('success', 'Transaksi withdraw berhasil diverifikasi.');
    }
}