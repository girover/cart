<?php

namespace Girover\Cart\Listeners;

use Girover\Cart\Events\CartDataWasUpdated;
use Girover\Cart\Models\Cart;

class UpdateCart {

    public function handle(CartDataWasUpdated $event)
    {
        $cart_row = Cart::where('user_id', $event->cart->owner)->first();
        
        if ($cart_row) {
            $cart_row->cart = serialize($event->cart);
            $cart_row->save();
        }
    }
}