<?php 
namespace App\Http\Middleware;

use Closure;
use App\ShoppingCart;

class BuildShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //obtenemos las sesion
        $shopping_cart_id = \Session::get('shopping_cart_id');
        //obtener el carrito
        $shopping_cart = ShoppingCart::findOrCreateBySessionId($shopping_cart_id);

        $request->shopping_cart = $shopping_cart;

        return $next($request);//hace que se mande la petición al que sigue(middle o controlador)
    }
}
