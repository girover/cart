<?php

namespace Girover\Cart;

use Girover\Cart\Console\CartCommand;
use Girover\Cart\Providers\EventServiceProvider;
use Girover\Cart\Services\DatabaseAuthCartService;
use Girover\Cart\Services\SessionCartService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CartServiceProvider extends PackageServiceProvider {

    public function configurePackage(Package $package) : void
    {
        $package->name('cart')
                ->hasMigrations(['create_carts_table']);
                //->hasConfigFile('tree')
                // ->hasViews()
                //->hasAssets()
                //->hasTranslations()
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        parent::register();
    }


    public function boot()
    {
        $this->app->singleton('cartService',function($app){
            return (config('cart.driver')=='session')? new SessionCartService : new DatabaseAuthCartService;
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                CartCommand::class,
            ]);
        }

        parent::boot();
    }
}