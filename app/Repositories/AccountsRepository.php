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


    public function getBalance(int $account_id): ?Collection
    {
        return collect($this->accountsModel->find($account_id));
    }

    /**
     * 
     */
    public function store(int $account_id, float $balance) : void
    {
        $this->accountsModel->query()->updateOrCreate(
            ['id' => $account_id],
            ['id' => $account_id, 'balance' => $balance],
        );
    }

}
