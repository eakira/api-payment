<?php

namespace App\Repositories;



use App\Interface\IAccountsRepository;
use App\Models\Accounts;
use App\Models\Events;
use Illuminate\Support\Collection;

class AccountsRepository implements IAccountsRepository
{

    public function __construct(
        private Accounts $accountsModel,
        private Events $eventsModel,
    )
    {
    }

    public function reset(): void
    {
        $this->accountsModel->query()->delete();
    }

}
