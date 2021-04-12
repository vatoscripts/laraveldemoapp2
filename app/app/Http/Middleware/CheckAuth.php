<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists(['user', 'Authenticated'])) {
            $request->session()->flush();
            //return redirect('/login')->withWarning('Your Session has Expired !');
            return redirect()->route('login')->withWarning('Your Session has expired !');
        }
        return $next($request);
    }
}
