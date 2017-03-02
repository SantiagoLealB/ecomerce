<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Mail\OrderUpdated;

class Order extends Model
{
	protected $fillable = ['recipient_name', 'line1', 'line2', 'city', 'country_code', 'state', 'postal_code', 'email', 'shopping_cart_id', 'status', 'total', 'guide_number']; 

    public static function createFromPayPalResponse($response, $shopping_cart){

    	$payer = $response->payer;
    	//obtener datos de envio, recibidos de paypal, convertir a hash
    	$orderData = (array) $payer->payer_info->shipping_address;
    	$orderData = $orderData[ key($orderData) ];

    	$orderData['email'] = $payer->payer_info->email;
    	$orderData['total'] = $shopping_cart->total();
    	$orderData['shopping_cart_id'] = $shopping_cart->id;

    	return Order::create($orderData);
    }

    public function address(){
    	return "$this->line1 $this->line2";
    }

    //ordenar ordenes por Id en el mes de forma desc
    public function scopeLatest($query){
    	return $query->orderID()->monthly();
    }

    public function scopeOrderID($query){
    	return $query->orderBy('id', 'desc');
    }

    //ordenes por id descendente
    public function scopeMonthly($query){
    	return $query->whereMonth('created_at', '=', date('m'));//m= mes actual
    }

    //envío de correos
    public function sendMail(){
        //se pued enviar a $this->email
        //$this- un objeto Order
        Mail::to('aries-leal@hotmail.com')->send(new OrderCreated($this));

    }

    //enviar email al actualizar datos
    public function sendUpdateMail(){
        Mail::to('aries-leal@hotmail.com')->send(new OrderUpdated($this));
    }

    //datos de ventas
    //obtener el total de todas las ordenes
    public static function totalMonth(){

    	return Order::monthly()->sum('total');

    }

    //obtener cuantas ventas se han hecho
    public static function totalMonthCount(){
    	return Order::monthly()->count();
    }

    //obtener el carrito
    public function shoppingCart(){
        return $this->belongsTo('App\ShoppingCart');
    }

    //obtener el Id de la orden
    public function shoppingCartId(){
        return $this->shoppingCart->custom_id;
    }
}
