<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    public function handle(Request $request, Closure $next, $role): Response
    {

        $allowedRoles = is_array($role) ? $role : explode('|', $role); // mendukung pipe (admin|director)

        if (!in_array(auth()->user()->role, $allowedRoles)) {
            return redirect()->route('index');
        }

        return $next($request);

        // return response()->json(['You do not have permission to access for this page.']);
        /* return response()->view('errors.check-permission'); */
    }

}