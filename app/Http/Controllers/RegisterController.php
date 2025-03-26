<?php

namespace App\Http\Controllers;

use DB;

use App\Models\SubmissionList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {

    public function partner(){

        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (Auth::user()->role == 'approval') {
                return redirect()->route('approval.home');
            }else if (Auth::user()->role == 'partner') {
                return redirect()->route('partner.home');
            }else if (Auth::user()->role == 'customer') {
                return redirect()->route('customer.home');
            }else{
                return redirect()->route('index');
            }
        } else {
            return view('landing.register', [
                'title' => 'Pendaftaran Mitra Angkot',
                'role' => 'partner'
            ]);
        }
        
    }

    public function customer(){

        if(Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (Auth::user()->role == 'approval') {
                return redirect()->route('approval.home');
            }else if (Auth::user()->role == 'partner') {
                return redirect()->route('partner.home');
            }else if (Auth::user()->role == 'customer') {
                return redirect()->route('customer.home');
            }else{
                return redirect()->route('index');
            }
        } else {
            return view('landing.register', [
                'title' => 'Pendaftaran Pengguna',
                'role' => 'customer'
            ]);
        }
    }

    public function storePartner(Request $request){
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mobile_phone' => 'required|regex:/^08[0-9]{8,11}$/',
            'email' => 'required|email|unique:users,email',
            'city_register' => 'required',
            'password' => 'required|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'mobile_phone.required' => 'Nomor HP wajib diisi.',
            'mobile_phone.regex' => 'Format nomor HP tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'city_register.required' => 'Kota tempat mendaftar wajib dipilih.',
            'city_register.exists' => 'Kota yang dipilih tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $partner = User::create([
            'name' => $request->nama_lengkap,
            'mobile_phone' => $request->mobile_phone,
            'email' => $request->email,
            'city_register' => $request->city_register,
            'password' => Hash::make($request->password),
            'role' => 'partner'
        ]);

        Auth::login($partner);

        // Redirect to dashboard or home
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Anda telah login.');
    }

    /**
     * Store a newly registered customer.
     */
    public function storeCustomer(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required|string|max:255',
                'mobile_phone' => ['required', 'string', 'regex:/^(\+62|62|0)[0-9]{9,12}$/', 'unique:users,mobile_phone'],
                'email' => 'required|email|unique:users,email'
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
                'mobile_phone.required' => 'Nomor HP wajib diisi.',
                'mobile_phone.regex' => 'Format nomor HP tidak valid. Gunakan angka saja (10-12 digit).',
                'mobile_phone.unique' => 'Nomor HP sudah terdaftar.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
            ]);
    
            // Jika validasi gagal, kembalikan error dalam format JSON
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Simpan data penumpang ke database
            $customer = User::create([
                'name' => $request->nama_lengkap,
                'mobile_phone' => $request->mobile_phone,
                'password' => Hash::make($request->password ?? 'defaultpassword'), // Pastikan password tidak kosong
                'email' => $request->email,
                'role' => 'customer'
            ]);
    
            // Login otomatis setelah registrasi
            Auth::login($customer);
    
            // Berhasil, kembalikan response JSON
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Anda telah login.'
            ]);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

}
