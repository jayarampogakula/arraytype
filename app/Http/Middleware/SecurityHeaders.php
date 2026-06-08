<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Block suspicious bots and automated scanners
        $userAgent = $request->header('User-Agent', '');
        $blockedAgents = ['sqlmap', 'nikto', 'nessus', 'masscan', 'nmap', 'python-requests', 'zgrab', 'dirbuster', 'havij'];
        foreach ($blockedAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                abort(403, 'Forbidden');
            }
        }

        // Block path traversal and known exploit paths
        $path = $request->path();
        $blockedPaths = ['wp-admin', 'wp-login', '.env', 'phpinfo', 'adminer', 'phpmyadmin', '../', '.git', 'xmlrpc'];
        foreach ($blockedPaths as $blocked) {
            if (stripos($path, $blocked) !== false) {
                abort(403, 'Forbidden');
            }
        }

        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.bunny.net; style-src 'self' 'unsafe-inline' https://fonts.bunny.net; font-src 'self' https://fonts.bunny.net; img-src 'self' data: https:;");
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
