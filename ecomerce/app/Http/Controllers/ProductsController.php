<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function __construct(){
        //solo los que estan logueados excepto show
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Mostrar toda la colleccion del recurso
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //desplegar la vista con el formulario que creara un nuevo producto
    public function create()
    {
        $product = new Product;
        return view('products.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //El de create se envia a store y este gusarda el producto
    public function store(Request $request)
    {
        //si viene un archivo en el request, 
        //y si el archivo se pudo subir(se guardo en carpeta temporal)
        $hasFile = $request->hasFile('cover') && $request->cover->isValid();

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->pricing = $request->pricing;
        $product->user_id = Auth::user()->id; //id del user autentificado

        if($hasFile){
            $extension = $request->cover->extension();
            $product->extension = $extension;
        }


        if($product->save()){
            //mover el archivo de la cap. temporal
            if($hasFile){
                //carpeta y nombre de la img
                $request->cover->storeAs('images', "$product->id.$extension");
            }

            return redirect('/products');
        }else{
            return view('products.create', ['product' => $product]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //muestra el producto con el id
    public function show($id)
    {
        $product = Product::find($id);//busca el prod
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //muestra un formulario para editar el prod con el id
    public function edit($id)
    {
         
         $product = Product::find($id);//busca el prod
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Actualiza el prod que se envio a edit 
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->pricing = $request->pricing;
 
        if($product->save()){
            return redirect('/products');
        }else{
            return view('products.edit', ['product' => $product]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Elimina el producto con el id
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products');
    }
}
