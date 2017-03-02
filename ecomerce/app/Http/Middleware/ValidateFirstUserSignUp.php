<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class ValidateFirstUserSignUp
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
        $userCount = user::count(); //cantida de user en la tabla
        
        if($userCount > 0 && !Auth::check()){
            return redirect('/');
        }

        return $next($request);
    }
}
