<?php

namespace App\Interface;

use Illuminate\Support\Collection;

interface IEventsStrategy
{

    /**
     * Reset the accounts (Route for testing)
     * @return Collection
     */
    public function event(Collection $data): Collection;

}
