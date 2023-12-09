<?php
namespace App\Services;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Jobs\TestJob;

class RabbitMQConsumerService
{
    protected $connection;
    protected $channel;
    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );
        $this->channel = $this->connection->channel();
    }

    public function consume($queueName)
    {
        $exchange = env('RABBITMQ_EXCHANGE_NAME');

        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->queue_bind($queueName, $exchange);

        $callback = function ($msg) {
            $jobData = json_decode($msg->body, true);
            $job = new TestJob($jobData);
            $this->dispatcher->dispatch($job);
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
