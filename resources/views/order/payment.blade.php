@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')
		<form method="post">
			{{csrf_field()}}
			<hr />

			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">Error!</h4>
				<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
				<hr>
				<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
			</div>

			<div class="alert alert-info" role="alert">
				<h4 class="alert-heading">Info!</h4>
				<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
				<hr>
				<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
			</div>

			@if (($message = Session::get('error') === null))
				<div class="alert alert-danger" role="alert">
					{!! $message !!}
				</div>
				<?php Session::forget('error');?>
			@endif

			<hr />
			<div class="pt-3 pb-4">
				<div class="row">
					<div class="col-6 text-center">
						<a href="{{url(route('order_checkout'))}}" class="btn btn-outline-info">
							<i class="fa fa-undo"></i> {{trans('Modify')}}
						</a>
					</div>
					<div class="col-6 text-center">
						<button type="submit" class="btn btn-outline-success">
							<i class="fa fa-paypal"></i> {{trans('Pay with Paypal')}}
						</button>
					</div>
				</div>
			</div>
		</form>
	</section>
@endsection