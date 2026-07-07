<?php

namespace App\Listeners;

use App\Models\Companies;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Companieslistener
{
    /**
     * Create the event listener.
     */
    protected $companies ; 
    public function __construct( Companies $companies )
    {
        $this->companies = $companies ; 
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $companies = $event->name ; 
    }
}