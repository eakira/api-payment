<?php

namespace App\Http\Controllers;

use App\Interface\IAccountsRepository;
use App\Interface\IEventsRepository;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    public function __construct(
        private IAccountsRepository $accountsRepo,
        private IEventsRepository   $eventsRepo
    )
    {
    }

    public function reset()
    {
        DB::beginTransaction();
        try {
            $this->eventsRepo->reset();
            $this->accountsRepo->reset();
            DB::commit();

            return $this->response(config('message.success.message'), config('message.success.status_code'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->response(config('message.error.message'), config('message.error.status_code'));
        }
    }
}
