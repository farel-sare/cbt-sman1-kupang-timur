<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user login dan rolenya sesuai dengan yang diizinkan
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Jika user mencoba mengakses rute yang bukan haknya, alihkan ke dashboard rolenya
        if (auth()->user()->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        if (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}
