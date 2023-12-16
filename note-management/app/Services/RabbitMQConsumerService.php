<?php
namespace App\Services;

use App\Events\UserCreatedEvent;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Jobs\TestJob;
use App\Models\User;

class RabbitMQConsumerService
{
    public $connection;
    public $channel;
    public $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
    }

    public function consume($queueName)
    {
        $exchange = config('rabbitmq.exchange_name');

        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->queue_bind($queueName, $exchange);

        $callback = function ($msg) {
            $jobData = json_decode($msg->body, true);
            event(new UserCreatedEvent($jobData));
            info($jobData);
            return $jobData;
        };

        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
