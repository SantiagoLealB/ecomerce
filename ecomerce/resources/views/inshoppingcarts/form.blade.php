{!! Form::open(['url' => '/in_shopping_carts', 'class' => 'add-to-cart', 'method' => 'POST']) !!}
	<input type="hidden" name="product_id" value="{{ $product->id }}">
	<input type="submit" value="Agregar al carrito" class="btn btn-info">
{!! Form::close() !!}