<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah role user sesuai
        $user = Auth::user();
        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request);
            }
        }

        // Jika role tidak sesuai, tampilkan error 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini');
    }
}
