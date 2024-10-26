<?php
namespace App\Strategy;

use App\Interface\IAccountsRepository;
use App\Interface\IEventsRepository;
use App\Interface\IEventsStrategy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DepositStrategy implements IEventsStrategy
{
    public function __construct(
        private IAccountsRepository $accountsRepo,
        private IEventsRepository   $eventsRepo        
    )
    {
    }

    /**
     * 
     */
    public function event(Collection $data) : Collection
    {
        $destination = $data->get('destination');
        $amount = $data->get('amount', 0);

        $destin = $this->accountsRepo->getBalance($destination);
        $balance = $destin->get('balance', 0) + $amount;
        
        DB::beginTransaction();
        try {
            $destin = $this->accountsRepo->store($destination, $balance);
            $destin = $this->eventsRepo->store($destination, 'deposit', $amount);
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception($e);

        }

        return collect(["destination" => ["id" => $destination, "balance" => $balance]]);
    }
}