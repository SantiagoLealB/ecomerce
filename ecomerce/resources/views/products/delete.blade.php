 {!! Form::open([ 'url' => '/products/' . $product->id, 'method' => 'DELETE', 'class' => 'inline-block' ]) !!}

 	<input type="submit" class="btn btn-link red-text no-padding no-margin no-transform" value="Eliminar">
 
 {!! Form::close() !!}

