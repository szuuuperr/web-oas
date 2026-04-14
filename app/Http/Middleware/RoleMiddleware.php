<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Cek apakah user yang login memiliki role yang diizinkan.
     * Penggunaan: middleware('role:admin') atau middleware('role:admin,manager')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (dipisah koma)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            // Redirect ke dashboard sendiri jika sudah login tapi role salah
            if ($user) {
                return redirect('/dashboard');
            }

            // Jika belum login, arahkan ke login
            return redirect()->route('login');
        }

        return $next($request);
    }
}
