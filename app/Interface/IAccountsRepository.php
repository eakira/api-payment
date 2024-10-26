<?php

namespace App\Interface;

use Illuminate\Support\Collection;

interface IAccountsRepository
{

    /**
     * Reset the accounts (Route for testing)
     * @return bool
     */
    public function reset(): void;

    /**
     * Get balance
     * int $account_id
     * @return ?Collection
     */
    public function getBalance(int $account_id) : ?Collection;

    /**
     * Store the account
     * int $account_id
     * float $balance
     * @return void
     */
    public function store(int $account_id, float $balance) : void;

}
