<?php

namespace Girover\Cart\Concerns;

use Girover\Cart\Models\Cart;

trait HasCart{

    public $cart;
    /**
     * The User has a car
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cartRelation()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    /**
     * Get the cart of this user
     * 
     * @return \Girover\Cart\Cart
     */
    public function cart()
    {
        if ($this->cart) {
            return $this->cart;
        }  
        $cart_service = app()->make('cartService');

        return $this->cart = $cart_service->getCart();
    }

    /**
     * Determine if this user has a cart in database
     * 
     * @return bool
     */
    public function hasCart()
    {
        return $this->cartRelation ? true: false;
    }
}