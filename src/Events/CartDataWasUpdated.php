<?php

namespace Girover\Cart\Events;

use Girover\Cart\Cart;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartDataWasUpdated {
    use Dispatchable, SerializesModels;

    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
}