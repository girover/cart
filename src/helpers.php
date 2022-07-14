<?php

if (! function_exists('shopping_cart')) {

    function shopping_cart() {
        
        static $cart = null;

        if ($cart === null) {

            // $cart_service = app()->make('cartService');
    
            // $cart =  $cart_service->getCart();
            $cart =  (app()->make('cartService'))->getCart();
        }

        return $cart;
    }

}