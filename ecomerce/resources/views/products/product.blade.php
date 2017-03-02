<div class="card product text-left">

			@if(Auth::check() && $product->user_id == Auth::user()->id)

				<div class="absolute actions">
					<a href="{{ url('/products/' . $product->id. '/edit') }}">Editar</a>

					@include('products.delete', ['product' => $product ]) 
				</div>

			@endif


			<h1>{{ $product->title}}</h1>
			<div class="row"> 
				<div class="col-sm-6 col-xs-12">
					@if($product->extension)
						<img src="{{url('/products/images/'.$product->id. '.' . $product->extension)}}" class="product-avatar">
					@endif
				</div>
				<div class="col-sm-6 col-xs-12">
					<p>
						<strong>Descripción</strong>
					</p>
					<p>
						{{ $product->description }}
					</p>
					<p>
						 @include('inshoppingcarts.form', ['product' => $product])
					</p>
				</div>
			</div>
		</div>