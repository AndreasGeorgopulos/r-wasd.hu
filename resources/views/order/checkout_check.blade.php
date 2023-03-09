@extends('layouts.index')
@section('content')
	<section class="container cart">
		@include('order._steps')
		<form method="post">
			{{csrf_field()}}
			<hr />
			@if(!empty($pageContentBlock_1))
				<div class="">{!! $pageContentBlock_1 !!}</div>
				<hr />
			@endif

			<div class="row">
				<div class="col-sm-6 p-4">
					@include('order._products')
				</div>
				<div class="col-sm-6 p-4">
					<h2 class="color-blue">{{trans('Contact')}}</h2>

					<div class="form-group mb-3">
						<label>{{trans('Full name')}}</label>
						<br/>
						<span class="color-blue">{{$model->name}}</span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('E-mail')}}</label>
						<br/>
						<span class="color-blue">{{$model->email}}</span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Phone')}}</label>
						<br/>
						<span class="color-blue">{{$model->phone}}</span>
					</div>

					<h2 class="mt-5 color-blue">{{trans('Shipping address')}}</h2>

					<div class="form-group mb-3">
						<label>{{trans('Country')}}</label>
						<br/>
						<span class="color-blue">{{$model->shipping_country->name}}</span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Zip')}}</label>
						<br/>
						<span class="color-blue">{{$model->shipping_zip}}</span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('City')}}</label>
						<br/>
						<span class="color-blue">{{$model->shipping_city}}</span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Address')}}</label>
						<br/>
						<span class="color-blue">{{$model->shipping_address}}</span>
					</div>

					<h2 class="mt-5 color-blue">{{trans('Notice')}}</h2>

					<div class="form-group mb-3 color-blue">
						{{$model->notice}}
					</div>
				</div>
			</div>

			<hr />
			@if(!empty($pageContentBlock_2))
				<div class="">{!! $pageContentBlock_2 !!}</div>
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
						<a href="{{url(route('order_payment'))}}" class="btn btn-outline-primary">
							<i class="fa fa-check"></i> {{trans('Continue')}}
						</a>
					</div>
				</div>
			</div>
		</form>
	</section>
@endsection