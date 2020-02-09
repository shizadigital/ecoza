<?php

namespace App\Http\Middleware;

use Closure, Session;

class ShizaAuthMiddleware
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
        $sess = Session::get(config('shiza.session.signin'));
        if(is_null($sess)) return redirect()->route('admin.auth.signin');
        
        return $next($request);
    }
}
