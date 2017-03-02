{!! Form::open(['url' => $url, 'method' => $method, 'files' => true])  !!}

	<div class="form-group">
		{{ Form::text('title', $product->title, [ 'class' => 'form-control', 'placeholder' => 'Nombre del producto']) }}
	</div>

	<div class="form-group">
		{{ Form::number('pricing', $product->pricing, [ 'class' => 'form-control', 'placeholder' => 'precio en centavos de dólar' ]) }}
		
	</div>

	<div class="form-group text-right">
		{{ Form::text('description', $product->description, [ 'class' => 'form-control', 'placeholder' =>'desctipción del producto']) }}
	</div>

	<div class="form-group">
		{{ Form::file('cover')}}
	</div>

	<div class="form-group text-right">
		<a href="{{ url('/products') }}">Regresar  a productos</a>
		<input type="submit" name="" value="enviar" class="btn btn-success">
	</div>

{!! Form::close() !!}