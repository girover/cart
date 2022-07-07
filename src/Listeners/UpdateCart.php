<?php

namespace Girover\Cart\Listeners;

use Girover\Cart\Events\CartDataWasUpdated;
use Girover\Cart\Models\Cart;
use Illuminate\Support\Facades\Session;

class UpdateCart {

    public function handle(CartDataWasUpdated $event)
    {
        if (config('cart.driver') === 'database') {
            $this->updateDatabaseCart($event->cart);
            return;
        }

        $this->updateSessionCart($event->cart);
    }

    private function updateDatabaseCart($cart) {

        $cart_row = Cart::where('user_id', $cart->owner)->first();
        
        if ($cart_row) {
            $cart_row->cart = serialize($cart);
            $cart_row->save();
        }
    }

    private function updateSessionCart($cart) {
        // session(['girover_cart' => serialize($cart)]);
        Session::put('girover_cart', serialize($cart));
    }

}