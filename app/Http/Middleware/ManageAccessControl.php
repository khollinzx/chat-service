<?php

namespace App\Http\Middleware;

use App\Models\OauthAccessToken;
use App\Models\User;
use App\Repositories\AdminRepository;
use App\Repositories\MemberRepository;
use App\Services\JsonResponseAPI;
use Closure;
use Illuminate\Http\Request;

class ManageAccessControl
{

    /**
     */
    public function __construct(){}

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        if(!$request->hasHeader('authorization')) return JsonResponseAPI::errorResponse("Access denied! No Authorization header was defined.", JsonResponseAPI::$UNAUTHORIZED);

        $guard = $request->guard?? 'user';//use this when using the Admin privilege access control

        if(!$guard) return JsonResponseAPI::errorResponse("Access denied! No guard passed.", JsonResponseAPI::$UNAUTHORIZED);

        if(!in_array($guard, [User::repo()->guard])) return JsonResponseAPI::errorResponse("Auth guard is invalid.", JsonResponseAPI::$UNAUTHORIZED);

        OauthAccessToken::setAuthProvider('users');

        return $next($request);
    }
}
