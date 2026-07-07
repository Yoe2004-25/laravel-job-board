<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Illuminate\Container\Attributes\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class UserLogRegister implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegister $event): void
    {
        $user = $event->user ; 
        Log::info('the user register' .$user->name);
        Session()->flash('the user is done'.$user->name);
    }
}