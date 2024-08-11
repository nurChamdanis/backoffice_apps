<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    public function handle(Request $request, Closure $next)
    {
        $userInput = $request->all();
        array_walk_recursive($userInput, function (&$userInput) {
            $userInput = strip_tags($userInput);
        });
        $request->merge($userInput);
        return $next($request);
    }

}
