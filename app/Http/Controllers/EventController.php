<?php

namespace App\Http\Controllers;

use App\Factory\EventFactory;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller
{
    public function __construct(
        private EventFactory $factory       
    )
    {
    }

    public function create(CreateEventRequest $request)
    {
        try {
            $data = collect($request->validated());

            $factory = $this->factory->getEventMethod(data_get($data, 'type'));
            $return = $factory->event($data);

            if($return->isEmpty())
                return $this->response(config('message.not_found.message'), config('message.not_found.status_code'));

            return $this->response($return->toArray(), config('message.success.status_code'));
        } catch (\Throwable $e) {
            send_log($e->getMessage());

            return $this->response(config('message.error.message'), config('message.error.status_code'));
        }
    }
}
