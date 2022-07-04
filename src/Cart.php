<?php

namespace Girover\Cart;

use Girover\Cart\Events\CartDataWasUpdated;

class Cart {

    /**
     * Id of owner of the cart in database table 'carts'
     */
    public $owner;

    /**
     * @var array The items added to the cart
     */
    protected $items = [];

    /**
     * @var int The total quantity of items in the cart
     */
    protected $total_quantity = 0;

    /**
     * @var double Total price of all items in the cart
     */
    protected $total_price = 0;

    /**
     * Get item from Cart
     * 
     * @param string $id
     * @return \Girover\Cart\CartItem|null
     */
    public function getItem($id)
    {
        return (array_key_exists($id,$this->items)) ? $this->items[$id] : null;
    }

    /**
     * Add new item the cart
     * 
     * @param mix $item Item to add to the cart
     * @param mix $id The key name in items array to associate the item with.
     * 
     * @return \Girover\Cart\CartItem
     */
    public function add($item, $id)
    {
        // Convert array to object if array is provided
        $item = is_array($item) ? (object)$item : $item;

        if ($this->hasItem($id)) {
            return $this->incrementItemQuantity($id);
        }

        $cart_item = new CartItem($item);
        
        $this->items[$id]=$cart_item;

        return $this->recalculate($item->price);
    }

    /**
     * To increment the quantity of a specific item in the cart.
     * 
     * @param mix $id The item in the cart that is associated to the given index(or key name).
     */
    public function incrementItemQuantity($id)
    {
        ($this->items[$id])->increment();

        return $this->recalculate(($this->items[$id])->price);
    }

    /**
     * To increment the quantity of a specific item in the cart.
     * 
     * @param mix $id The item in the cart that is associated to the given index(or key name).
     */
    public function decrementItemQuantity($id)
    {
        ($this->items[$id])->decrement();

        return $this->recalculate(($this->items[$id])->price);
    }

    /**
     * Determine if the cart has specific item
     * @param string $key
     * 
     * @return bool
     */
    public function hasItem($id)
    {
        return (array_key_exists($id, $this->items)) ? true : false;
    }

    /**
     * Increment total quantity
     */
    public function incrementTotalQuantity()
    {
        $this->total_quantity++;
    }

    /**
     * Increment total quantity
     */
    public function incrementTotalPrice($price)
    {
        $this->total_price += $price;
    }

    /**
     * Recalculate the total quantity and the total price
     * when adding new item to the cart
     */
    public function recalculate($add_price)
    {
        $this->incrementTotalQuantity();
        $this->incrementTotalPrice($add_price);
        
        event(new CartDataWasUpdated($this));
    }

    /**
     * Get all items in the cart.
     * 
     * @return array
     */
    public function allItems()
    {
        return $this->items;
    }

    /**
     * Determine if the cart has specific item
     * @param string $key
     * 
     * @return bool
     */
    public function removeItem($id)
    {
        if ($this->hasItem($id)) {

            unset($this->items[$id]);

            event(new CartDataWasUpdated($this));
            
            return true;
        }

        return false;
    }

    /**
     * Get total quantity of items the cart
     * 
     * @return int
     */
    public function totalQuantity()
    {
        return $this->total_quantity;
    }

    /**
     * Get total price of the cart
     * 
     * @return double
     */
    public function totalPrice()
    {
        return $this->total_price;
    }
}