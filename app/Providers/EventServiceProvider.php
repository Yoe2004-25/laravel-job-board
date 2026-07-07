<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ApplicationRegister;
use App\Events\CompaniesRegister;
use App\Events\JobRegister;  
class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        ApplicationRegister ::class => [
            CompaniesRegister::class => [
                JobRegister :: class => [
                    
                ],
            ],
        ],
        
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}