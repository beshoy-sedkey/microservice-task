<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bindMethod(TestJob::class . '@handle', function ($job) {
            return $job->handle();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $listener = $this->app->make(\App\Listeners\RabbitMQListener::class);
        // $listener->handle();
    }
}
