<?php

namespace App\Interface;

use App\Models\Events;

interface IEventsRepository
{

    /**
     * Reset the events (Route for testing)
     * @return Events
     */
    public function reset(): void;
    
    public function store(int $account_id, string $type, float $amount): void;

}
