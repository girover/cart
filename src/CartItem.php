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
    public $quantity = 0;

    /**
     * @var double How much is the total price of this item.
     */
    public $total_price = 0;

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
        
        $this->increment();
    }

    /**
     * Increment the quantity and the total price for this item
     * 
     */
    public function increment()
    {
        $this->quantity++; 
        $this->total_price = $this->quantity * $this->item->price;
    }

    /**
     * Decrement the quantity and the total price for this item
     * 
     */
    public function decrement()
    {
        $this->quantity--; 
        $this->total_price = $this->quantity * $this->item->price;
    }

    public function getItem()
    {
        return $this->item;
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