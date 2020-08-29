<?php

namespace App\Http\Middleware;

use Closure;
use Hash;

class CheckApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        if(Hash::check(env('TOKEN'), $req->header('token'))){
            return $next($req);
        }
        else{
            return response()->json(['error'=>'Request Denied']);
        }
    }
}
