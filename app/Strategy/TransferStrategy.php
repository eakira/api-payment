<?php

namespace App\Strategy;

use App\Interface\IAccountsRepository;
use App\Interface\IEventsRepository;
use App\Interface\IEventsStrategy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransferStrategy implements IEventsStrategy
{
    public function __construct(
        private IAccountsRepository $accountsRepo,
        private IEventsRepository   $eventsRepo
    ) {}

    /**
     * 
     */
    public function event(Collection $data): Collection
    {
        $orign_id = $data->get('origin');
        $destination_id = $data->get('destination');
        $amount = $data->get('amount', 0);

        $orignData = $this->accountsRepo->getBalance($orign_id);
        $balanceOrigin = $orignData->get('balance', 0) - $amount;
        if ($balanceOrigin < 0) {
            throw new \DomainException(config('message.insufficient_balance'));
        }

        $destinationData = $this->accountsRepo->getBalance($destination_id);
        $balanceDestination = $destinationData->get('balance', 0) + $amount;

        DB::beginTransaction();
        try {
            //transfer from origin
            $this->accountsRepo->store($orign_id, $balanceOrigin);
            $this->eventsRepo->store($orign_id, 'transfer', $amount);

            //deposit to destination
            $this->accountsRepo->store($destination_id, $balanceDestination);
            $this->eventsRepo->store($destination_id, 'deposit', $amount);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception($e);
        }

        return collect([
            "origin" => ["id" => $orign_id, "balance" => $balanceOrigin], 
            "destination" => ["id" => $destination_id, "balance" => $balanceDestination]
        ]);
    }
}
