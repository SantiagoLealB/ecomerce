<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//controlador inicial
Route::get('/', 'MainController@home');

Route::get('/carrito', 'ShoppingCartsController@index');
Route::post('/carrito', 'ShoppingCartsController@checkout');

Route::get('/payments/store', 'PaymentsController@store');


Auth::routes();

//generar las rutas para el controlador products    
Route::resource('products', 'ProductsController');
//obtener las imagenes
Route::get('products/images/{filename}', function($filename){
	$path = storage_path("app/images/$filename");

	if(!\File::exists($path))
		abort(404);

	$file = \File::get($path);
	$type = \File::mimeType($path);
	$response = Response::make($file, 200);
	$response->header('Content-Type', $type);

	return $response;
});


//para agregar y eliminar prods del carrito
Route::resource('in_shopping_carts', 'ProductsInShoppingCartsController', [
		'only' => ['store', 'destroy']
]);

//para las compras de los usuarios
Route::resource('compras', 'ShoppingCartsController',[
		'only' => ['show']
	]);

Route::resource('orders', 'OrdersController',[
		'only' => ['index' , 'update']
	]);


Route::get('/home', 'HomeController@index');


