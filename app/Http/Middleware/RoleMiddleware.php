<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!$user->hasRole($roles)) {
            throw new UnauthorizedException('Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}