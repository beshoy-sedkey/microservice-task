<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserCreatedEvent;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreatedEvent $event): void
    {
        info($event->userData);
        try {
            $user = User::create($event->userData);
            if ($user instanceof JWTSubject) {
                $token = JWTAuth::fromSubject($user);
                info($token);
                // You can now use the $token as needed
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
