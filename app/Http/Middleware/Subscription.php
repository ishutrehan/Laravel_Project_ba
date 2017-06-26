<?php

namespace App\Http\Middleware;

use Closure;

class Subscription
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

        if ( (auth()->user()->subscription == 0) || auth()->user()->expire_at == "" ) {
            return redirect()->route('no-subscription');
        }

        return $next($request);

    }
}
