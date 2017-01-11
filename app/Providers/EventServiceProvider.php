<?php

namespace SisFin\Providers;

use SisFin\Events\BancoStoredEvent;
use SisFin\Listeners\BancoLogoUploadListener;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BancoStoredEvent::class => [
            BancoLogoUploadListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
