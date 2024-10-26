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

}
