@extends('layouts.index')
@section('content')
	<section class="container product">
		<h1 class="font-russo-one color-orange">{{$model->getTitle()}}</h1>

		<div class="content">
			<div class="row">
				<div class="col-sm-6">
					@if($model->hasIndexImage())
						<img src="{{$model->getIndexImageFileUrl('page')}}" class="img-fluid img-thumbnail" alt="{{$model->getTitle()}}" />
					@endif
				</div>
				<div class="col-sm-6 font-exo-2 color-gray">{!! $model->getLead() !!}</div>
			</div>

			<div class="row">
				<div class="col-12 font-exo-2 color-gray">{!! $model->getBody() !!}</div>
			</div>

			<p class="font-exo-2 color-gray">€{!! number_format($model->price, 2, '.', ',') !!}</p>

			<div id="add-to-cart"
			     data-product-id="{{$model->id}}"
			     data-csrf-token="{{@csrf_token()}}"
			     data-add-url="{{url(route('cart_set'))}}"
			></div>
		</div>
	</section>
@endsection