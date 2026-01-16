<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('student')->check()) {  
            $student = Auth::guard('student')->user();

            if ($student->is_default == 1) {  
                abort(Response::HTTP_FORBIDDEN, 'You have to reset your password');  
            }  
        }  
        return $next($request);
    }
}
