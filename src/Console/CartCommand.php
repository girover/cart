<?php

namespace Girover\Cart\Console;

use Girover\Cart\CartServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CartCommand extends Command
{
    public $signature = 'cart:install';

    public $description = 'Installing girover\\cart package';

    public function handle()
    {
        $this->info('Starting installing package girover\\cart');
        $this->publishMigrations();
        $this->runMigrate();
    }

    public function cartPublish($tag = '')
    {
        if ($tag === '') {
            return 'please provide --tag to run the command';
        }

        $r = Artisan::call('vendor:publish', [
            '--provider'=> CartServiceProvider::class,
            '--tag' => $tag
        ]);
        if ($r === 0) {
            return $this->line('<fg=green>Succeed</>');
        }
        return $this->line('<fg=red>Failed</>');
    }

    public function publishMigrations()
    {
        $this->info('<fg=yellow>Publishing Migrations....</>');
        return $this->cartPublish('cart-migrations');
    }

    public function runMigrate()
    {
        $this->info('<fg=yellow>Migrating database....</>');
        if(Artisan::call('migrate') === 0){
            return $this->line('<fg=green>Succeed</>');
        }
        return $this->line('<fg=green>Faild</>');
    }

}
