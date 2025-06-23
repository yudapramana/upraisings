<?php

namespace App\Http\Controllers;

use App\Models\AngkotType;
use App\Models\EWallet;
use App\Models\User;
use Illuminate\Http\Request;

class AngkotController extends Controller
{
    public function getAngkot($id)
    {
        $ewallet = EWallet::where('qrcode_string', $id)->with('user.vehicle')->first();
        return $ewallet->user;
    }

    public function index()
    {
        $angkots = User::where([
                            'role' => 'partner',
                            'account_verification' => 'pending'
                        ])
                        ->with('ewallet', 'vehicle.angkotType')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // $flattened = $angkots->map(function ($angkot) {
        //     return [
        //         ...$angkot->toArray(),
        //         ...($angkot->ewallet?->toArray() ?? []),
        //         ...($angkot->vehicle?->toArray() ?? []),
        //         ...($angkot->vehicle?->angkotType?->toArray() ?? []),
        //     ];
        // });

        // collect($flattened)->mapInto(User::class);
        // return $angkots;

        $angkotTypes = AngkotType::orderBy('route_number')->get();
        $params = [
            "titlePages"    => 'Manajemen - Kelola Angkot',
            "angkots"         => $angkots,
            "angkotTypes"         => $angkotTypes,
        ];

        return view('dashboard.angkot.index', $params);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mobile_phone' => 'required|string|max:20',
            'email'        => 'required|email|unique:angkots,email',
            'city_register'=> 'required|string',
            'password'     => 'required|string|min:6',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'mobile_phone' => $request->mobile_phone,
            'email'        => $request->email,
            'city_register'=> $request->city_register,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Data angkot berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $angkot = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mobile_phone' => 'required|string|max:20',
            'email'        => 'required|email|unique:angkots,email,' . $angkot->id,
            'city_register'=> 'required|string',
        ]);

        $angkot->update([
            'nama_lengkap' => $request->nama_lengkap,
            'mobile_phone' => $request->mobile_phone,
            'email'        => $request->email,
            'city_register'=> $request->city_register,
        ]);

        return redirect()->back()->with('success', 'Data angkot berhasil diupdate.');
    }

    public function destroy($id)
    {
        $angkot = User::findOrFail($id);
        $angkot->delete();

        return response()->json(['success' => true]);
    }
}
