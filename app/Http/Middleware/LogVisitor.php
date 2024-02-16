<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Users\VisitorLog;

class LogVisitor
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
        $ip = $request->ip();
        $GetVisitorLog_data = VisitorLog::where('ip_address', $ip)
                                        ->whereDate('created_at', '=', Carbon::today()->toDateString());
        if ($GetVisitorLog_data->count() < 1) {
            VisitorLog::create([
                'ip_address' => $ip,
            ]);
        }

        return $next($request);
    }
}
