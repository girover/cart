<?php

namespace Girover\Cart\Services;

use Girover\Cart\Cart as CartCart;
use Girover\Cart\Concerns\CartServiceInterface;

class DatabaseAuthCartService implements CartServiceInterface {

public $crated_at;

    public function userHasCart() {
        return auth()->user()->cartRelation ? true: false;
    }

    public function createNewCartForUser() {

        $cart = $this->newCart();

        auth()->user()->cartRelation()->create(['user_id'=>auth()->user()->getKey(), 'cart'=>serialize($cart)]);
                
        return $cart;
    }

    public function recreateNewCartForUser() {

        $cart = $this->newCart();

        auth()->user()->cartRelation()->update(['cart'=>serialize($cart)]);

        return $cart;
    }
    
    public function getCart() {

        $cart_row = auth()->user()->cartRelation;
        // user has no row in table 'carts' in database
        if ($cart_row === null) {
            return $this->createNewCartForUser();
        }
        $cart = unserialize($cart_row->cart);
        // user has row in table 'carts' but field 'cart' is empty or not an object of cart
        if (($cart == false) || (! $cart instanceof CartCart)) {
            return $this->recreateNewCartForUser();
        }

        return $cart;
    }

    private function newCart()
    {
        $cart = new CartCart;
        $cart->owner = auth()->user()->getKey();

        return $cart;
    }
}