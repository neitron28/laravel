<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @param string|null $redirectTo
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $redirectTo = null)
    {
        if ($request->input('age') <= 18) {
            return redirect($redirectTo ?? 'login');
        }

        return $next($request);
    }
}
