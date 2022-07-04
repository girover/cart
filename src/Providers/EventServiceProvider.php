<?php

namespace Girover\Cart\Providers;

use Girover\Cart\Events\CartDataWasUpdated;
use Girover\Cart\Listeners\UpdateCart;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CartDataWasUpdated::class => [
            UpdateCart::class,
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
    }
}