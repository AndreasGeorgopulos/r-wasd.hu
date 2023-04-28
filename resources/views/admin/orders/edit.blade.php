@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Order')}}: {{$model->order_code}} [{{$model->id}}]</h1>
@stop

@section('content')
	<form method="post" enctype="multipart/form-data">
	{{csrf_field()}}
	@include('admin.layout.messages')
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						@include('admin.orders._view_customer')
						<hr />
						@include('admin.orders._view_products')
					</div>
					<div class="col-sm-6">
						@include('admin.orders._view_shipping_info')
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route($model->getBackRouteName()))}}" class="btn btn-default">{{trans('Back')}}</a>

				@if($model->status != \App\Models\Order::STATUS_DONE)
					@php
					switch ($model->status) {
						case \App\Models\Order::STATUS_SENT:
							$saveButtonTitle = trans('Order complete');
							break;
						case \App\Models\Order::STATUS_NEW:
						default:
							$saveButtonTitle = trans('Package sent');
					}
					@endphp
					<button type="submit" class="btn btn-info pull-right">{{$saveButtonTitle}}</button>
				@endif
			</div>
		</div>
	</form>
@endsection