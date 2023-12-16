<?php

namespace App\Console\Commands;

use App\Services\RabbitMQConsumerService;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;

class ListenForNewUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:new-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listens for new user creation events from RabbitMQ';

    protected $dispatcher;
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rabbitmqConnection = new RabbitMQConsumerService($this->dispatcher);
        $consumeMessage = $rabbitmqConnection->consume(config('rabbitmq.queue'));
        info($consumeMessage);

    }
}
