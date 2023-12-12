<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\OnboardRequest;
use App\Models\OauthAccessToken;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\JsonResponseAPI;

class AuthController extends Controller
{
    public function __construct(protected User $user){}

    /**
     * @param OnboardRequest $request
     * @param string $guard
     * @return JsonResponse
     */
    public function login(OnboardRequest $request, string $guard = 'user'): JsonResponse
    {
        try {
            /** validates @var  $validated */
            $validated = $request->validated();

            if(! $this->user::repo()->findByWhere(['phone'=> $validated['phone']]))
                $this->user::repo()->createModel(['phone' => $validated['phone'], 'password' => Hash::make($validated['password']),]);

            $credentials = ['phone'=> $validated['phone'], 'password'=> $validated['password']];

            if(!Auth::guard($guard)->attempt($credentials)) return JsonResponseAPI::errorResponse('Invalid login credentials.');

            /**
             * Get the User Account and create access token
             */
            $Account = $this->user::repo()->findByWhere(['phone'=> $validated['phone']]);

            /** set accessToken @var $accessToken */
            $accessToken = OauthAccessToken::createAccessToken($Account, $guard);

            return JsonResponseAPI::successResponse('Login succeeded.', ($accessToken));

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::errorResponse("Internal server error.", JsonResponseAPI::$BAD_REQUEST);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {

            $user = Auth::user();
            $user->token()->revoke();

            return JsonResponseAPI::successResponse('Logout Successful');

        } catch (\Exception $e) {
            Log::error('Error logging out: ' . $e->getMessage());
            return JsonResponseAPI::errorResponse('Error logging out user', JsonResponseAPI::$BAD_REQUEST);
        }
    }

}
