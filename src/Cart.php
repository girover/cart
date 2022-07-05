<?php

namespace Girover\Cart;

use Girover\Cart\Events\CartDataWasUpdated;
use Illuminate\Database\Eloquent\Model;

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
        $item = $this->convertToCartItem($item);
        // $item = is_array($item) ? (object)$item : $item;

        if ($this->hasItem($id)) {
            return $this->increaseItemQuantity($id);
        }

        $cart_item = new CartItem($item);
        
        $this->items[$id]=$cart_item;

        return $this->increaseAndRecalculate($item->price);
    }

    /**
     * To convert the given item to object.
     * If item is instance of \Illuminate\Database\Eloquent\Model only attributes
     * will be converted to an object
     * 
     * @param mix $item
     * @return mix
     */
    public function convertToCartItem($item)
    {
        if (is_array($item)) {
            return (object)$item;
        }
        
        if ($item instanceof Model) {
            return (object)$item->attributesToArray();
        }

        return $item;
    }

    /**
     * To increase the quantity of a specific item in the cart.
     * 
     * @param mix $id The item in the cart that is associated to the given index(or key name).
     */
    public function increaseItemQuantity($id)
    {
        if (! $this->hasItem($id)) {
            return;
        }
        ($this->items[$id])->increase();

        return $this->increaseAndRecalculate(($this->items[$id])->price);
    }

    /**
     * To increase the quantity of a specific item in the cart.
     * 
     * @param mix $id The item in the cart that is associated to the given index(or key name).
     */
    public function decreaseItemQuantity($id)
    {
        if (! $this->hasItem($id)) {
            return;
        }
        if (($this->items[$id])->decrease()) {
            $this->decreaseAndRecalculate(($this->items[$id])->price);
        }
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
     * Recalculate the total quantity and the total price
     * when adding new item to the cart
     */
    public function increaseAndRecalculate($add_price)
    {
        $this->total_quantity++;
        $this->total_price += $add_price;
        
        event(new CartDataWasUpdated($this));
    }

    /**
     * Recalculate the total quantity and the total price
     * when adding new item to the cart
     */
    public function decreaseAndRecalculate($add_price)
    {
        $this->total_quantity--;
        $this->total_price -= $add_price;
        
        event(new CartDataWasUpdated($this));
    }

    /**
     * Recalculate the total quantity and the total price
     * when adding new item to the cart
     */
    public function decreaseItemAndRecalculate(CartItem $item)
    {
        $this->total_quantity -= $item->quantity();
        $this->total_price    -= $item->totalPrice();
        
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
     * Remove specific item from the cart,
     * and decrease the total quantity and total price
     * @param string $id
     * 
     * @return bool
     */
    public function removeItem($id)
    {
        if ($this->hasItem($id)) {

            $item = $this->items[$id];
            unset($this->items[$id]);

            $this->decreaseItemAndRecalculate($item);

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