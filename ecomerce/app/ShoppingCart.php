<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = ['status'];

    public static function findOrCreateBySessionId($shopping_cart_id){

    	if($shopping_cart_id){//si ya hay un carrito
    		return ShoppingCart::findBySessionId($shopping_cart_id);
    	} else{//crear un carrito
    		return ShoppingCart::createBySessionId();
    	}
    }

    public static function findBySessionId($shopping_cart_id){
    	//buscar el carrioto con el id en la bd
    	return ShoppingCart::find($shopping_cart_id);
    }

    public static function createBySessionId(){
    	//crear un carrito en la bd
    	return ShoppingCart::create(['status' => 'incompleted']);
    }

    //cuantos productos hay en el carrit
    public function productsSize(){
    	return $this->products()->count();
    }

    //total a pagar
    public function total(){

        return $this->products()->sum('pricing');
    }

    //generar id de compra para el usuario
    public function generateCustomId(){
        //agregar la hora para romper el patron del md5 
        return md5("$this->id $this->updated_at");

    }
    //actualizar el id y el status
    public function updateCustomIdAndStatus(){

        \Session::remove('shopping_cart_id');//eliminar la sesión una vez pagado
        $this->status = 'approved';
        $this->custom_id = $this->generateCustomId();
        $this->save();
    }

    //actualizar el custumid y pasar el satutus del carrito a aprovado
    public function approve(){
        $this->updateCustomIdAndStatus();
    }

    //---------relaciones------------
   
    public function productsInShoppingCarts(){

        return $this->hasMany('App\ProductInShoppingCart');
    }

     //productos que hay en un carrito, hace un inner
    public function products(){
        //clase con la que se hace la relacion y la tabla pivot
        return $this->belongsToMany('App\Product', 'products_in_shopping_carts');
    }

    //un carrito tiene una orden
    public function order(){
        return $this->hasOne('App\Order')->first();
    }
}
