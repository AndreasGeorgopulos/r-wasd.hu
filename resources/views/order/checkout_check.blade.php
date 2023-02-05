@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')
		<form method="post">
			{{csrf_field()}}
			<hr />
			<div class="row">
				<div class="col-sm-6">
					@include('order._products')
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-3">
						<label>{{trans('Name')}} *</label>
						<br/>
						{{$order['name']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('E-mail')}} *</label>
						<br/>
						{{$order['email']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Phone')}} *</label>
						<br/>
						{{$order['phone']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Country')}} *</label>
						<br/>
						{{$order['shipping_country_id']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Zip')}} *</label>
						<br/>
						{{$order['shipping_zip']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('City')}} *</label>
						<br/>
						{{$order['shipping_city']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Address')}} *</label>
						<br/>
						{{$order['shipping_address']}}
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Notice')}}</label>
						<br/>
						{{$order['notice']}}
					</div>
				</div>
			</div>

			<hr />
			<div class="pt-3 pb-4">
				<div class="row">
					<div class="col-6 text-center">
						<a href="{{url(route('order_checkout'))}}" class="btn btn-outline-info">
							<i class="fa fa-undo"></i> {{trans('Modify')}}
						</a>
					</div>
					<div class="col-6 text-center">
						<a href="{{url(route('order_payment'))}}" class="btn btn-outline-primary">
							<i class="fa fa-check"></i> {{trans('Continue')}}
						</a>
					</div>
				</div>
			</div>
		</form>
	</section>
@endsection