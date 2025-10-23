<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireAdminPassword
{
    public function handle(Request $request, Closure $next)
    {
        // Allow access to the check/verify and logout routes to avoid redirect loop
        $allowed = [
            route('admin.check', [], false),
            route('admin.verify', [], false),
            route('admin.logout', [], false),
        ];

        // If already authenticated in session, allow
        if ($request->session()->get('is_admin_authenticated') === true) {
            return $next($request);
        }

        // Allow the admin-check and verify endpoints to proceed
        if (in_array($request->path(), [
            trim(parse_url(route('admin.check', [], false), PHP_URL_PATH), '/'),
            trim(parse_url(route('admin.verify', [], false), PHP_URL_PATH), '/'),
            trim(parse_url(route('admin.logout', [], false), PHP_URL_PATH), '/'),
        ])) {
            return $next($request);
        }

        // Redirect to admin check form
        return redirect()->route('admin.check');
    }
}
