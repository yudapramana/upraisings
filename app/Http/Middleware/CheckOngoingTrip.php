<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trip;

class CheckOngoingTrip
{
   public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user) {
            $ongoingTrip = \App\Models\Trip::where('user_id', $user->id)
                                        ->where('status', 'ongoing')
                                        ->first();

            // Jika user memiliki trip ongoing dan bukan di halaman terkait trip
            if ($ongoingTrip && !str_contains($request->path(), 'trip')) {
                return redirect()->route('trip.show.customer', $ongoingTrip->id)
                                ->with('warning', 'Selesaikan perjalanan Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }

}
