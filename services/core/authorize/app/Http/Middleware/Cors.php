<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $origin = $request->header('Origin');
        $protocol = 'https://';
        $tenant = 'disallowed';

        if ($origin) {
            $split = explode('://', $origin);
            $protocol = $split[0] . '://';
            $tenant = explode('.', $split[1])[0];
        } else {
            $tenant = $_GET['app'] ?? $tenant;
        }

        if ($tenant === 'stafflify') {
            $tenant = '';
        } else {
            $tenant = $tenant . '.';
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', $protocol . $tenant . env('APP_URL'))
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    }
}
