<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Paypal;
use App\Order;

class PaymentsController extends Controller
{
     public function __construct(){
        $this->middleware('shoppingcart');
    }


	//recibir de paypay para ejecutar el cobro
    public function store(Request $request){
    	 //La busqueda de cart se hace en el middlewae shoppingcart
        $shopping_cart = $request->shopping_cart; 

        $paypal = new Paypal($shopping_cart);
       
       	//guardar la respuesta de paypal sobre el pago
        $response = $paypal->execute($request->paymentId, $request->PayerID);
    	
    	//si se cobro correctamente
    	if($response->state == 'approved'){
    		$order = Order::createFromPayPalResponse($response, $shopping_cart);
    		$shopping_cart->approve();//si el carrito se proceso correctamente
     	}
 		//----termina la compra

    	return view('shopping_carts.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);

    }
}
