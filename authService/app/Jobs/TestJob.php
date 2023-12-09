<?php

namespace App\Jobs;

use App\Services\RabbitMQService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $data ;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
        $rabbitmq = new RabbitMQService();
        $rabbitmq->publishMessage(json_encode($data));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $connection = new AMQPStreamConnection(
        //     env('RABBITMQ_HOST'),
        //     env('RABBITMQ_PORT'),
        //     env('RABBITMQ_USER'),
        //     env('RABBITMQ_PASSWORD'),
        //     env('RABBITMQ_VHOST')
        // );
        // $channel = $connection->channel();

        // $channel->queue_declare('hello', false, false, false, false);

        // echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        // $callback = function ($msg) {
        //     echo ' [x] Received ', $msg->body, "\n";
        //     // Process the message
        //     TestJob::dispatch($msg->body);
        // };

        // $channel->basic_consume('hello', '', false, true, false, false, $callback);

        // while ($channel->is_consuming()) {
        //     $channel->wait();
        // }

        // $channel->close();
        // $connection->close();
    }
}
