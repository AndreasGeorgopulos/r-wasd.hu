@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')

		<div id="cart-page"
			data-load-url="{{url(route('cart_get'))}}"
			data-set-url="{{url(route('cart_set'))}}">
		</div>
		<hr />
		<div class="pt-3 pb-4 text-center">
			<a href="{{url(route('order_checkout'))}}" class="btn btn-outline-primary">
				<i class="fa fa-list-alt"></i> {{trans('Checkout')}}
			</a>
		</div>
	</section>
@endsection