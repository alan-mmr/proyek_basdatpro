<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdministrator
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil User & Role dari Database
        $user = Auth::user();
        $roleName = $user->roles->first()->nama_role ?? '';

        // 3. Cek Keyword 'Administrator'
        if (stripos($roleName, 'Administrator') !== false) {
            return $next($request);
        }

        // 4. Tolak
        abort(403, 'AKSES DITOLAK. Khusus Administrator.');
    }
}