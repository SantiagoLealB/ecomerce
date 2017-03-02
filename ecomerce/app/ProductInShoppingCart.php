<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInShoppingCart extends Model
{
	//especificar la tabla a usar, a veces hay error por las reglas de laravel
	public $table = "products_in_shopping_carts";
    protected $fillable = ['product_id', 'shopping_cart_id'];

    public static function productsCount($shopping_cart_id){
    	return ProductInShoppingCart::where('shopping_cart_id', $shopping_cart_id)
    									->count();
    }
}
