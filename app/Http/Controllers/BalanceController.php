<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBalanceRequest;
use App\Interface\IAccountsRepository;

class BalanceController extends Controller
{
    public function __construct(
        private IAccountsRepository $accountsRepo,
    )
    {
    }

    public function show(GetBalanceRequest $request)
    {
        try {
            $data = $request->validated();

            $return = $this->accountsRepo->getBalance(data_get($data, 'account_id'));

            if($return->isEmpty())
                return $this->response(config('message.not_found.message'), config('message.not_found.status_code'));

            return $this->response($return->toArray(), config('message.success.status_code'));
        } catch (\Throwable $e) {
            send_log($e->getMessage());

            return $this->response(config('message.error.message'), config('message.error.status_code'));
        }
    }
}
