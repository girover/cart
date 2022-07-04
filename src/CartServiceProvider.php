<?php

namespace Girover\Cart;

use Girover\Cart\Commands\CartCommand;
use Girover\Cart\Providers\EventServiceProvider;
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                CartCommand::class,
            ]);
        }

        parent::boot();
    }
}