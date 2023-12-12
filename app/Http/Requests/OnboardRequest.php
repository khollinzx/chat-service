<?php

namespace App\Http\Requests;

use App\Services\JsonResponseAPI;
use Illuminate\Http\Exceptions\HttpResponseException;

class OnboardRequest extends BaseFormRequest
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /** Validate header content-type */
        if(! $this->hasHeader('Content-Type') || $this->header('Content-Type') !== 'application/json')
            throw new HttpResponseException(JsonResponseAPI::errorResponse('Include Content-Type and set the value to: application/json in your header.', 204));

        switch (basename($this->url())) {
            case "signin": return $this->handleSignup();
        }
    }

    /**
     * @return array
     */
    private function handleSignup(): array
    {
        return [
            'phone' => [
                "required",
                "digits:11",
            ],
            'password' => 'required|min:8'
        ];
    }
}
