<?php

namespace App\Listeners;

use App\Models\Jobs;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class JobListener
{
    /**
     * Create the event listener.
     */

    protected $job ; 
    public function __construct(Jobs $job)
    {
        $this->job = $job ; 
    }

    /**
     * Handle the event.
     */
    public function handle(object  $event): void
    {
        $job = $event->job;
        Session::flash('job_name', 'the job name ' . $job->name);
        Log::info('the job is reached '. $job->name);
    }
}