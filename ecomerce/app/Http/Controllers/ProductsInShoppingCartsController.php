<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;
use App\ProductInShoppingCart;
 
class ProductsInShoppingCartsController extends Controller
{
     public function __construct(){
        $this->middleware('shoppingcart');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //La busqueda de cart se hace en el middlewae shoppingcart
        $shopping_cart = $request->shopping_cart; 

        //insertar un producto al carrito
        $response = ProductInShoppingCart::create([
            'shopping_cart_id' => $shopping_cart->id,
            'product_id' => $request->product_id
        ]);

        //si la petición es ajax
        if($request->ajax()){
            //responder con un json
            return response()->json([
                'products_count' => ProductInShoppingCart::productsCount($shopping_cart->id)
            ]);
        }

        if($response){
            return redirect('/products');//estaba en /carrito
        }else{
            return back();//regresar 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
