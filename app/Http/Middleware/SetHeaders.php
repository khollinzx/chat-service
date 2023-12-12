<?php

namespace App\Http\Middleware;

use App\Services\JsonResponseAPI;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->hasHeader('accept') || $request->header('accept') !== "application/json")
            return JsonResponseAPI::errorResponse('The Header is required to have {Accept: application/json}');

        return $next($request);
    }
}
