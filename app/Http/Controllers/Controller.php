<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /** welcome to route
     * @return string
     */
    public function welcome(): string
    {
        return "Welcome to chat-service app ".env("APP_ENV")." API Version 1";
    }

    /**
     * This returns a signed-in User Id
     * @return mixed
     */
    public function getUserId(): int
    {
        return auth()->id();
    }

    /**
     * This returns a signed-in User Model(instance)
     * @return Authenticatable|User
     */
    public function getUser(): Authenticatable|User
    {
        return auth()->user();
    }

    /**
     * This returns a signed-in User Model(instance)
     * @return mixed
     */
    public function getUserToken()
    {
        return auth()->user()->token();
    }

    /**
     * Translates an array to pagination
     * @param array $collections
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function arrayPaginator(array $collections, Request $request): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $limit = !$limit ? 10 : $limit; //if limit was not available or set to 0
        $offset = ($page * $limit) - $limit;

        return new LengthAwarePaginator(
            array_slice($collections, $offset, $limit, false),
            count($collections),
            $limit,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
