@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')

		@if(!empty($pageContentBlock_1))
			<div class="">{!! $pageContentBlock_1 !!}</div>
			<hr />
		@endif
		<div id="cart-page"
			data-load-url="{{url(route('cart_get'))}}"
			data-set-url="{{url(route('cart_set'))}}">
		</div>
		<hr />
		@if(!empty($pageContentBlock_2))
			<div class="">{!! $pageContentBlock_2 !!}</div>
			<hr />
		@endif
		<div class="pt-3 pb-4 text-center">
			<a href="{{url(route('order_checkout'))}}" class="btn btn-outline-primary">
				<i class="fa fa-list-alt"></i> {{trans('Checkout')}}
			</a>
		</div>
	</section>
@endsection