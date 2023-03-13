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

					<form method="post" action="{{url(route('cart_set'))}}">
						{{csrf_field()}}
						<input type="hidden" name="product_id" value="{{$model->id}}" >

						<div class="row mt-5 mb-5">
							<div class="col-3">
								<input type="number" name="amount" value="1" class="form-control" />
							</div>
							<div class="col-4">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-cart-plus"></i> Add to cart
								</button>
							</div>
							<div class="col-5 font-exo-2 color-orange text-end p-2">
								€{!! number_format($model->price, 2, '.', ',') !!}
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-12 font-exo-2 color-gray">{!! $model->getBody() !!}</div>
			</div>
		</div>
	</section>
@endsection