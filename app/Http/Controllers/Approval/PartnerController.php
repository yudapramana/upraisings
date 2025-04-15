<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $datas = User::where([
                            'role' => 'partner',
                            'account_verification' => 'pending'
                        ])
                        ->orderBy('created_at', 'desc')->get();

                        $params = [
                            "titlePages"    => 'Partner need to verified List',
                            "datas"         => $datas,
                        ];

        return view('dashboard.partner.registered', $params);
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->account_verification = $request->account_verification;
        $data->updated_at = now();
        $data->save();

        return redirect()->route('partner-verification.index')->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return response()->json(['success' => true]);
    }
}
