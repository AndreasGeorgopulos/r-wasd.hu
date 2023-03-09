@extends('layouts.index')
@section('content')
	<section class="container-fluid container-md product">
		<h1 class="font-russo-one color-orange text-center text-md-start">{{$model->getTitle()}}</h1>

		<div class="content p-3 p-md-5">
			<div class="row">
				<div class="col-md-6 mb-2">
					@if($model->hasIndexImage())
						<img src="{{$model->getIndexImageFileUrl('page')}}" class="img-fluid" alt="{{$model->getTitle()}}" />
					@endif
				</div>
				<div class="col-md-6 font-exo-2 color-gray">
					{!! $model->getLead() !!}
					<p class="font-exo-2 color-gray">€{!! number_format($model->price, 2, '.', ',') !!}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-12 font-exo-2 color-gray">{!! $model->getBody() !!}</div>
			</div>



			<div id="add-to-cart"
			     data-product-id="{{$model->id}}"
			     data-csrf-token="{{@csrf_token()}}"
			     data-add-url="{{url(route('cart_set'))}}"
			></div>
		</div>
	</section>
@endsection