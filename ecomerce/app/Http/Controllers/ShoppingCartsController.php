<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;
use App\PayPal;
use App\Order;


class ShoppingCartsController extends Controller
{

    public function __construct(){
        $this->middleware('shoppingcart');
    }
 
    //obtener los productos del carrito y el total a pagar
    //Request, obj en el que se soloco el carrito en le middle
    public function index(Request $request)
    {
        //La busqueda de carrito se hace en el middlewae shoppingcart
        $shopping_cart = $request->shopping_cart; 

        $products = $shopping_cart->products()->get();
        $total = $shopping_cart->total();

        return view('shopping_carts.index', ['products' => $products, 'total' => $total]);
    }

     public function checkout(Request $request){
        //La busqueda de carrito se hace en el middlewae shoppingcart
        $shopping_cart = $request->shopping_cart; 

        $paypal = new PayPal($shopping_cart);
        //generar el pago 
        $payment = $paypal->generate();
        //mandar a paypal para pagar
        return redirect($payment->getApprovalLink());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shopping_cart = ShoppingCart::where('custom_id', $id)->first();

        $order = $shopping_cart->order();

        return view('shopping_carts.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);
    }
}
