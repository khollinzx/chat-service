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
use App\Http\Resources\UsersResource;
use App\Models\Admin;
use App\Models\User;
use App\Services\SmileIdentityService;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepositoryAbstract
{

    /**
     * @var string
     */
    protected string $databaseTableName = 'users';

    public string $guard = 'user';

    /**
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model, $this->databaseTableName);
    }


    public function getByWhereNotContact(string $column, int $recordId, array $ids): mixed
    {
        return $this->model::where($column, '!=', $recordId)
            ->WhereNotIn('id', $ids)
            ->sharedLock()->get();
    }

}
