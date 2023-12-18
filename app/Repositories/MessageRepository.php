<?php

namespace App\Repositories;

use App\Abstractions\AbstractClasses\BaseRepositoryAbstract;
use App\Abstractions\Implementations\EmailProviders\Sengrid;
use App\Abstractions\Implementations\PaymentGateways\PaystackService;
use App\Abstractions\Implementations\SMSs\SendchampService;
use App\Abstractions\Implementations\SMSs\TermiiService;
use App\Abstractions\Implementations\SMSs\TwilioService;
use App\Abstractions\Implementations\ThirdPartyServices\RetailCodeService;
use App\Abstractions\Implementations\ThirdPartyServices\RetopinService;
use App\Abstractions\Implementations\ThirdPartyServices\ShaggoService;
use App\Http\Resources\MessageResource;
use App\Models\Admin;
use App\Models\Message;
use App\Models\User;
use App\Services\SmileIdentityService;
use Illuminate\Support\Facades\Log;

class MessageRepository extends BaseRepositoryAbstract
{

    /**
     * @var string
     */
    protected string $databaseTableName = 'messages';

    /**
     *
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        parent::__construct($model, $this->databaseTableName);
    }

    /**
     * @param array $queries
     * @return mixed
     */
    public function getUserMessages(array $queries): mixed
    {
        return $this->model::with($this->model->relationships)->where($queries)->sharedLock()->orderByDesc('id')->get();
    }

}
