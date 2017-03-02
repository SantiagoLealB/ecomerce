<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ShoppingCart;

class ShoppingCartProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($vista){

            //buscar las sesión con el id (la primera vez es null la sesion no existe), para no sobreescribir el carrito
            $shopping_cart_id = \Session::get('shopping_cart_id');

            //encontrar o crear la sesión 
            $shopping_cart = ShoppingCart::findOrCreateBySessionId($shopping_cart_id);

            //colar dentro de las sesiones del servidor
            \Session::put('shopping_cart_id' , $shopping_cart->id);

            //enviar laa variable a todas a vistas, cuantos productos hay en el carrito
            $vista->with('productsCount', $shopping_cart->productsSize());

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
