<?php
namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare('Dayra', 'fanout', false, true, false);
    }

    public function publishMessage(string $messageBody): void
    {
        $message = new AMQPMessage($messageBody);
        $this->channel->basic_publish($message, 'Dayra');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
