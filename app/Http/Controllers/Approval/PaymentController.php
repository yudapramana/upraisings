<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Ewallet;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function index()
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

        return view('dashboard.payment.verification', $params);
    }

    public function verify($id, Request $request)
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
}