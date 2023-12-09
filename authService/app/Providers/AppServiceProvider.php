<?php

namespace App\Providers;

use App\Listeners\RabbitMQListener;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Services\Repository\UserRepository;
use App\Services\Repository\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(UserRepositoryInterface::class , UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
