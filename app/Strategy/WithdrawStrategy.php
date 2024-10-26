<?php
namespace App\Strategy;
use App\Interface\IEventsStrategy;
use Illuminate\Support\Collection;

class WithdrawStrategy implements IEventsStrategy
{

    /**
     * 
     */
    public function event() : Collection
    {
        return collect(['withdraw']);
    }
}