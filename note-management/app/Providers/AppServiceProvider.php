<?php

namespace App\Providers;

use App\Services\Repositories\NoteRepository;
use App\Services\Repositories\NoteRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(NoteRepositoryInterface::class , NoteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      //
    }
}
