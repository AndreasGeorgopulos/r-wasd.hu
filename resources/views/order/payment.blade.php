@extends('layouts.index')
@section('content')
	<section class="container cart rounded">
		@include('order._steps')
		<form method="post">
			{{csrf_field()}}
			<hr />
			@if (($message = Session::get('error') !== null))
				<div class="alert alert-danger" role="alert">
					{!! $message !!}
				</div>
				<?php Session::forget('error');?>
			@endif

			<hr />
			@if(!empty($pageContentBlock))
				<div class="">{!! $pageContentBlock !!}</div>
				<hr />
			@endif

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