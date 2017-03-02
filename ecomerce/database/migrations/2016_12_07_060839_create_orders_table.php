<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $tabla){
            $tabla->increments('id');
            $tabla->integer('shopping_cart_id')->unsigned();
            $tabla->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            $tabla->string('line1');
            $tabla->string('line2')->nullable(true);
            $tabla->string('city');
            $tabla->string('postal_code');
            $tabla->string('country_code');
            $tabla->string('state');
            $tabla->string('recipient_name');
            $tabla->string('email');
            $tabla->string('status')->default('creado');
            $tabla->string('guide_number')->nullable(true);
            $tabla->string('total');

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
        Schema::drop('orders');
    }
}
