<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $date = Carbon::today();

            // Use firstOrCreate to prevent duplicate entries for the same IP on the same day
            Visitor::firstOrCreate(
                ['ip_address' => $ip, 'visit_date' => $date],
                ['user_agent' => $request->userAgent()]
            );
        } catch (\Exception $e) {
            // Silently ignore tracking errors so they don't break the application
        }

        return $next($request);
    }
}
