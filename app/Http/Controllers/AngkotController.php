<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use Illuminate\Http\Request;

class AngkotController extends Controller
{
    public function getAngkot($id)
    {
        $ewallet = EWallet::where('qrcode_string', $id)->with('user.vehicle')->first();
        return $ewallet->user;
    }
}
