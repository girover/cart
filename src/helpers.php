<?php

if (! function_exists('shopping_cart')) {

    function shopping_cart() {
        
        $cart_service = app()->make('cartService');

        return $cart_service->getCart();
    }

}