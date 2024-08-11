<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Setting\App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $mode = json_decode($val->value);
        if ($mode->mode == 'on') {
            $msg = $mode->title;
            return response()->json([
                'error'   => true,
                "message" => $msg
            ], 429);
        }
        return $next($request);
    }
}
