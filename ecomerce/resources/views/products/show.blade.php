@extends('layouts.app')

@section('content')
	
	<div class="container text-center">
		@include('products.product', ['product' => $product])
	</div>

@endsection