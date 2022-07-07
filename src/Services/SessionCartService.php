<?php

namespace Girover\Cart\Services;

use Girover\Cart\Cart;
use Girover\Cart\Concerns\CartServiceInterface;

class SessionCartService implements CartServiceInterface {
    

    public function createNewCartInSession() {

        session(['girover_cart'=> serialize($this->newCart())]);

        return unserialize(session('girover_cart'));
    }
    
    public function getCart() {

        if(session('girover_cart') == null){
            return $this->createNewCartInSession();
        }

        return unserialize(session('girover_cart'));
    }

    private function newCart()
    {
        $cart = new Cart;
        $cart->owner = 0;

        return $cart;
    }
}