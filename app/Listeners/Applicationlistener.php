<?php

namespace App\Listeners;

use App\Events\ApplicationRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

class Applicationlistener
{
    /**
     * Create the event listener.
     */

    protected $Application ; 
    public function __construct(Application $Application)
    {
        $this->Application = $Application ; 
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $Application = $event->Application ; 
        Session()->flash('The name of Application' . $Application->name) ; 
        Log::info('the Application is done' . $Application->name) ; 
    }
}