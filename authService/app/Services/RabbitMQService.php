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
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare(config('rabbitmq.exchange_name'), config('rabbitmq.exchange_type'), false, true, false);
    }

    public function publishMessage(string $messageBody): void
    {
        $message = new AMQPMessage($messageBody);
        $this->channel->basic_publish($message, config('rabbitmq.exchange_name'));
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
