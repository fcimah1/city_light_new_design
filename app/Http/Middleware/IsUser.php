<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->user_type == 'customer' ||
                auth::user()->user_type == 'seller' ||
                Auth::user()->user_type == 'delivery_boy')
            {
                Log::info('User type check passed');
                return $next($request);
            }
            } else{
                Log::info('User type check failed');
                session(['link' => url()->current()]);
                return redirect()->route('login');
            }
    }
}
