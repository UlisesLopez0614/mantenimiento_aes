<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyWorkshops
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            if(Auth::user()->isWorkshop()){
                return $next($request);
            }
            return redirect()->route('workshops');
        }
        abort(403, 'GTF Out Here!');
    }
}
