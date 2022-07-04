<?php

namespace Girover\Cart\Concerns;

use Girover\Cart\Cart as CartCart;
use Girover\Cart\Events\CartCreated;
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

        if ($cart_row = $this->cartRelation) {
            $cart = unserialize($cart_row->cart);
            // user has cart row in table 'carts' but cart object not stored in databse           
            if (! $cart instanceof CartCart) {
                return $this->recreateNewCartForUser();
            }

            $this->cart = $cart;
            
            return $this->cart;
        }

        return $this->createNewCartForUser();

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

    /**
     * Create new cart for the user in database table 'carts'
     * 
     * @return \Girover\Cart\Cart
     */
    public function createNewCartForUser()
    {
        $cart = new CartCart;
        $cart->owner = $this->id;

        $this->cartRelation()->create(['user_id'=>$this->getKey(), 'cart'=>serialize($cart)]);
        $this->cart = $cart;
        
        return $cart;
    }

    /**
     * User id exists in database table 'carts', but the field 'cart' is empty
     * or not is instance of \Girover\Cart\Cart
     * 
     * @return \Girover\Cart\Cart
     */
    public function recreateNewCartForUser()
    {
        $cart = new CartCart;
        $cart->owner = $this->id;

        $this->cartRelation()->update(['cart'=>serialize($cart)]);
        $this->cart = $cart;

        return $cart;
    }
}