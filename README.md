# Shopping Cart Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/girover/cart.svg?style=flat-square)](https://packagist.org/packages/girover/cart)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/girover/cart/run-tests?label=tests)](https://github.com/girover/cart/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/girover/cart/Check%20&%20fix%20styling?label=code%20style)](https://github.com/girover/cart/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/girover/cart.svg?style=flat-square)](https://packagist.org/packages/girover/cart)


---
## Content

  - [Introduction](#introduction)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [Usage](#usage)
    - [Authenticated User](#authenticated-user)
    - [Session User](#session-user)
  - [Testing](#testing)
  - [Changelog](#changelog)
  - [Contributing](#contributing)
  - [Security Vulnerabilities](#security-vulnerabilities)
  - [Credits](#credits)
  - [License](#license)


## Introduction
**girover/cart** is a package for e-commerce websites to deal with shopping car.
## Prerequisites
- Laravel 8+
- PHP 8+
- Mysql 5.7+
## Installation
You can add the package via **composer**:

```bash
composer require girover/cart
```

Before installing the package you should configure your database.  

Then you can install the package by running Artisan command   
```bash
php artisan cart:install
```

this command will take care of the following tasks:   
 - Publishing Config file ```config\cart.php``` to the config folder of your Laravel application.   
 - Publishing migration files to folder ```Database\migrations``` in your application.   
 - Migrate the published migrations.    

## Configuration
```girover/cart``` offers two ways to use the cart in your application.   
 - Authenticated User using database driver for storing cart data.
 - Session driver to store cart data in session.

To specify which way you should use, you can add a driver to ```config/cart.php``` file

```php
    return [
        'driver' => 'database',
        //'driver' => 'session',
    ]
```
When setting driver to ```database```, the cart data will be stored in database table ```carts```. And users should be authenticated to access cart functionality.   
When setting driver to ```session```, no database is used and data will be stored in session.
In addition no authenticated users are required to access cart functionality.

In database cart your ```User``` model must use trait ```Girover\Cart\Concerns\HasCart```.
## Usage
 To start using the cart, you can use the global helper function ```shopping_cart```.   
 So you can this function to add items, remove, increase quantities or decrease.

 ```php
    // CartController

    shopping_cart()->add(['id'=>'1', 'name'=>'Iphone 13', 'price'=>1000], 'id');
 ```
Notice that the second argument takes an attribute's name to make sure that items are associated with a specific key, which makes it easier for counting and processing items.
If you choose ```name``` for example, so every time you add new item with name ```Iphone 13``` to the cart then only quantity and total price of this item will be changed.   

You can also pass a model as first parameter to the cart's ```add``` method.   

```php

    use App\Models\Product;

    $product = Product::find(1);

    shopping_cart()->add($product, $product->id);

```   

To increase quantity of specific item in the cart, you can use the method ```increaseItemQuantity($key)```   

```php

    $product = Product::find(1);
    shopping_cart()->increaseItemQuantity($product->id);

```
## Testing

## Changelog

## Security Vulnerabilities
## Credits
## License