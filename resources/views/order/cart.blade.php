@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')

		@if(!empty($pageContentBlock_1))
			<div class="">{!! $pageContentBlock_1 !!}</div>
			<hr />
		@endif

		@include('order._cart_items')

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