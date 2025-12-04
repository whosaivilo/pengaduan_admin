<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

        public function handle(Request $request, Closure $next, string $role): Response
        {
            // Pastikan user login dulu
            if (! Auth::check()) {
                return redirect()->route('auth')
                    ->withErrors('Silahkan login terlebih dahulu!');
            }

            // Cek apakah role sesuai
            if (Auth::user()->role !== $role) {
                return abort(403, 'Akses ditolak.');
            }
            return $next($request);
        }
    }
