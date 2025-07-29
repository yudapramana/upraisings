<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * Tampilkan halaman profil mitra.
     */
    public function indexCustomer()
    {
        $user = Auth::user();

        // dd($user);
        return view('customer.profile', compact('user'));
    }

    /**
     * Update profil mitra.
     */
    public function updateCustomer(Request $request)
    {
        $userAuth = Auth::user();
        $user = User::find($userAuth->id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'city_register' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'city_register' => $request->city_register,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }


    /**
     * Tampilkan halaman profil mitra.
     */
    public function indexPartner()
    {
        $user = Auth::user();
        return view('partner.profile', compact('user'));
    }

    /**
     * Update profil mitra.
     */
    public function updatePartner(Request $request)
    {
        $userAuth = Auth::user();
        $user = User::find($userAuth->id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_phone' => 'nullable|string|max:15',
            'city_register' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data user
        $user->update([
            'name' => $request->name,
            'mobile_phone' => $request->mobile_phone,
            'city_register' => $request->city_register,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
