@extends('layouts.app')

@section('content')

	<header class="big-padding text-center blue-grey white-text">
		<h1>Compra completada</h1>
	</header>

	<div class="container">
		<div class="card large-padding">
				
			<h3>Tu pago fue <span class="{{ $order->status }}">{{ $order->status }}</span> </h3>
			<p>Corrobora los datos de tu envío</p>

			<div class="row large-padding">
				<div class="col-xs-6">Correo</div>
				<div class="col-xs-6">{{ $order->email }}</div>
			</div>

			<div class="row large-padding">
				<div class="col-xs-6">Dirección</div>
				<div class="col-xs-6">{{ $order->address() }}</div>
			</div>

			<div class="row large-padding">
				<div class="col-xs-6">Código Postal</div>
				<div class="col-xs-6">{{ $order->postal_code }}</div>
			</div>

			<div class="row large-padding">
				<div class="col-xs-6">Ciudad</div>
				<div class="col-xs-6">{{ $order->city }}</div>
			</div>

			<div class="row large-padding">
				<div class="col-xs-6">Estado y país</div>
				<div class="col-xs-6">{{ "$order->state $order->country_code" }}</div>
			</div>

			<dir class="text-center top-space">
				<a href="{{ url('/compras/' . $shopping_cart->custom_id) }}">Link Permanente de tu compra </a>
			</dir>

		</div>
	</div>

@endsection

