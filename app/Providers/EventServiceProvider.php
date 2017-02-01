<?php

namespace SisFin\Providers;

use SisFin\Events\BancoStoredEvent;
use SisFin\Listeners\BancoLogoUploadListener;
use SisFin\Listeners\ContaBancariaSetDefaultListener;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;

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
        ],
        RepositoryEntityCreated::class => [
            ContaBancariaSetDefaultListener::class
        ],
        RepositoryEntityUpdated::class => [
            ContaBancariaSetDefaultListener::class
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
