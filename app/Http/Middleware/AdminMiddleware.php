<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->type_compte !== 'admin') {
            return redirect('/')->with('danger', 'Accès refusé.');
        }

        return $next($request);
    }
}
