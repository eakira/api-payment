<?php
namespace App\Strategy;
use App\Interface\IEventsStrategy;
use Illuminate\Support\Collection;

class DepositStrategy implements IEventsStrategy
{

    /**
     * 
     */
    public function event() : Collection
    {
        return collect(['deposit']);
    }
}