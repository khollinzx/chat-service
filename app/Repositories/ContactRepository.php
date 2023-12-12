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
use App\Http\Resources\ContactResource;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\User;
use App\Services\Helper;
use App\Services\SmileIdentityService;
use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactRepository extends BaseRepositoryAbstract
{

    /**
     * @var string
     */
    protected string $databaseTableName = 'contacts';

    /**
     *
     * @param Contact $model
     */
    public function __construct(Contact $model)
    {
        parent::__construct($model, $this->databaseTableName);
    }
    /***
     * @param User $owner
     * @param int $userId
     * @return Model|null
     */
    public function setUserContact(User $owner, int $userId): ?Model
    {
        try {
            $record = null;
            DB::transaction(function () use (&$record, $owner, $userId) {
                $key = $this->generateChatKey();
                $this->createModel(['owner_id' => $owner->getId(), 'user_id' => $userId, 'chat_key' => $key]);
                $this->createModel(['owner_id' => $userId, 'user_id' => $owner->getId(), 'chat_key' => $key]);
            });

            return $record;
        } catch (\Exception $exception) {
            Log::error($exception);

            return null;
        }
    }

    /**
     * @return string|null
     */
    public function generateChatKey(): string|null
    {
        try {
            $unique = false;
            $string = null;

            while (!$unique)
            {
                $key =  Utils::generateUniqueConversationKey();
                if(!$this->findByWhere(["chat_key" => $key]))
                {
                    $string = $key;
                    $unique = true;
                }
            }
            return $string;

        }catch (\Exception $exception) {
            Log::error($exception);

            return null;
        }
    }

}
