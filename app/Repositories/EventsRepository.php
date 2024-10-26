<?php

namespace App\Repositories;

use App\Interface\IEventsRepository;
use App\Models\Events;

class EventsRepository implements IEventsRepository
{
    protected Events $model;

    public function __construct(Events $events)
    {
        $this->model = $events;
    }

    public function reset(): void
    {
        $this->model->query()->delete();
    }
}
