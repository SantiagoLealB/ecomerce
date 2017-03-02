<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
class OrdersController extends Controller
{

    public function __construct(){
        //solo los que estan logueados
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //mostrar todas las rdenes de compra
    public function index()
    {
        $orders = Order::latest()->get();//llamar al scope esta en Order

        $totalMonth = Order::totalMonth();
        $totalMonthCount = Order::totalMonthCount();

        return view('orders.index', ['orders' => $orders, 'totalMonth' => $totalMonth, 'totalMonthCount' => $totalMonthCount]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //acualizar la orden
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        $field = $request->name;//nombre del campo a amodificar

        $order->$field = $request->value;
        $order->save();
        return $order->field;//retornar campo actualizado
    }
}
