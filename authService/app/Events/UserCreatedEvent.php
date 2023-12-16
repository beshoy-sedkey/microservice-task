<?php

namespace App\Events;

use App\Models\User;
use App\Services\RabbitMQService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $user;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $rabbitmq = new RabbitMQService();
        $userWithPassword = $this->user->toArray();
        $userWithPassword['password'] = $this->user->password;
        $rabbitmq->publishMessage(json_encode($userWithPassword));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
