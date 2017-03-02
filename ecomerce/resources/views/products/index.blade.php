@extends('layouts.app')

@section('content')
	<div class="big-padding text-center blue-grey white-text"> 
		<h1>Productos</h1>
	</div>
	<div class="container">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Título</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Operación</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $product)
					<tr>
						<td>{{ $product->id}}</td>
						<td>{{ $product->title}}</td>
						<td>{{ $product->description}}</td>
						 <td>{{ $product->pricing}}</td>
						<td> 
							<a href="{{ url('/products/'.$product->id) }}">Ver </a>
							<a href="{{ url('/products/' . $product->id . '/edit') }}">Editar</a>
							@include('products.delete', ['product' => $product])
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="floating">
		<a href=" {{ url('/products/create') }}" class="btn btn-primary btn-fab">
			<i class="material-icons">Add</i>
		</a>
	</div>
@endsection