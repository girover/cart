<?php

namespace Girover\Cart;

use Girover\Cart\Exceptions\CartException;

class CartItem{

    /**
     * @var mix $item the item to add to the cart.
     */
    protected $item;

    /**
     * @var int How many of this item is added to cart.
     */
    protected $quantity = 0;

    /**
     * @var double How much is the total price of this item.
     */
    protected $total_price = 0;

    /**
     * instantiate a new object of cart item
     * 
     * @param mix $item the item to add to the cart
     */
    public function __construct($item) {
        $this->setAttributes($item);
    }

    /**
     * Set attributes to the CartItem
     * 
     * @param mix $item
     */
    public function setAttributes($item):void
    {
        $this->item = $item;
        
        $this->increase();
    }

    /**
     * increase the quantity and the total price for this item
     * 
     */
    public function increase()
    {
        $this->quantity++; 
        $this->total_price = $this->quantity * $this->item->price;
    }

    /**
     * decrease the quantity and the total price for this item
     * @return bool if quantity already is 0 will return false, 
     * otherwise true is returned
     */
    public function decrease()
    {
        if ($this->quantity == 0) {
            return false;
        }

        $this->quantity--; 
        $this->total_price = $this->quantity * $this->item->price;

        return true;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function quantity()
    {
        return $this->quantity;
    }

    public function totalPrice()
    {
        return $this->total_price;
    }

    /**
     * To get a given attribute if exists otherwise returns null
     * 
     * @return mix|null
     */
    public function __get($key)
    {
        return (property_exists($this->item, $key)) ? $this->item->{$key} : null;
    }
}