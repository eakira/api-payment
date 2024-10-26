<?php

namespace App\Factory;

use App\Interface\IEventsStrategy;
use App\Strategy\DepositStrategy;
use App\Strategy\TransferStrategy;
use App\Strategy\WithdrawStrategy;

class EventFactory
{

    public static function getEventMethod(string $type) : IEventsStrategy
    {
        switch ($type) {
            case 'deposit':
                return new DepositStrategy;
            case 'withdraw':
                return new WithdrawStrategy;
            case 'transfer':
                return new TransferStrategy;
        }

    }
}