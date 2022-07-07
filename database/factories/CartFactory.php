<?php

namespace Girover\Cart\Database\Factories;

use Girover\Cart\Cart as CartCart;
use \Girover\Cart\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;


class CartFactory extends Factory
{
    protected $model = Cart::class;

    
    public function definition()
    {
        return [
            'user_id' => 1,
            'cart'    => $this->newCart(),
        ];
    }

    private function newCart()
    {
        $cart = new CartCart;

        for ($i=0; $i < 9; $i++) { 
            $item = (object)['id'=>$this->faker->rand(1,10), 'name'=>$this->faker->name(), 'price'=>$this->faker->numerify('####')];
            $cart->add($item, $item->id);
        }

        return serialize($cart);
    }
}
