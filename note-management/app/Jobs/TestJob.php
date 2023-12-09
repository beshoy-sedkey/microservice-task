<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @param mixed $data Data to be processed by the job.
     */
    public function __construct($data)
    {

        $this->data = $data;
        if ($this->data['user']) {
            info($this->data['user']);
            return;
        }


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // info('ssssss');;
        // // Your processing logic here. For example:
        info($this->data['name']);
        Log::info('Processing data:', ['data' => $this->data]);

        // // Process the data
        // // ...
    }
}
