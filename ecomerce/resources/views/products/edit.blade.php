@extends('layouts.app')

@section('content')
	<div class="container white">
		<h1>Editar Producto</h1>

		@include('products.form', ['product' => $product, 'url' => '/products/' . $product->id, 'method' => 'PUT'])

	</div>

@endSection