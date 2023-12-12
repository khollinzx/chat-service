<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentCustomer;
use App\Models\NinRestriction;
use App\Models\OffnetUser;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\VirtualTopUp;
use App\Rules\ValidPhoneNumberRule;
use App\Services\CustomError;
use App\Services\Helper;
use App\Services\JsonResponseAPI;
use App\Services\ProductService;
use App\Services\ThirdPartyProviderService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class BaseFormRequest extends FormRequest
{
    /**
     * BaseFormRequest constructor.
     */
   public function __construct()
   {
       parent::__construct();
   }

    /**
     * THis overrides the default throwable failed message in json format
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(JsonResponseAPI::errorResponse($validator->errors()->first(), JsonResponseAPI::$UNPROCESSABLE_ENTITY));
    }
}
