<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsInShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_in_shopping_carts', function(Blueprint $tabla){

            $tabla->increments('id');
            $tabla->integer('product_id')->unsigned();
            $tabla->integer('shopping_cart_id')->unsigned();
            //llave foranea a product
            $tabla->foreign('product_id')->references('id')->on('products');
            //llave foranea a shopping_cart
            $tabla->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            
            $tabla->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_in_shopping_carts');
    }
}
