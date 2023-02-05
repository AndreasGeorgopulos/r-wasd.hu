@extends('layouts.index')
@section('content')
	<section class="container product">
		<h1 class="font-russo-one color-orange">{{$model->getTitle()}}</h1>
		<p class="font-exo-2 color-gray">{!! $model->getLead() !!}</p>
		<p class="font-exo-2 color-gray">{!! $model->getBody() !!}</p>
		<p class="font-exo-2 color-gray">€{!! number_format($model->price, 2, '.', ',') !!}</p>

		<div id="add-to-cart"
		     data-product-id="{{$model->id}}"
		     data-csrf-token="{{@csrf_token()}}"
		     data-add-url="{{url(route('cart_set'))}}"
		>
		</div>
	</section>
@endsection