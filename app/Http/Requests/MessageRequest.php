<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Services\JsonResponseAPI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MessageRequest extends BaseFormRequest
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
            case "send": return $this->handleSendMessage();
        }
    }

    /**
     * @return array
     */
    private function handleSendMessage(): array
    {
        return [
            'message' => ["required", "string"]
        ];
    }
}
