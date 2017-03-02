<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Realizar cambios
        Schema::create('products', function(Blueprint $tabla){
            $tabla->increments('id');

            $tabla->integer('user_id')->unsigned()->index();
            $tabla->string('title');
            $tabla->text('description');
            $tabla->decimal('pricing', 9, 2);//maximo 7 int y 2 decimales

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
        //revertisr cambios
        Schema::drop('products');
    }
}
