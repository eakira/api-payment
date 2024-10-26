<?php

namespace App\Providers;

use App\Interface\IAccountsRepository;
use App\Interface\IEventsRepository;
use App\Repositories\AccountsRepository;
use App\Repositories\EventsRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IEventsRepository::class, EventsRepository::class);
        $this->app->bind(IAccountsRepository::class, AccountsRepository::class);
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
