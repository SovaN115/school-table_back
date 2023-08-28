<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $admin = Admin::where('token', $token)->get();

        if(isset($admin[0])){
            return $next($request);
        }

        return response()->json([
            'error' => 'unauthorized',
            'token' => $token
        ], 200);
    }
}
