@extends('layouts.index')
@section('content')

	<span itemscope itemtype ="https://schema.org/Product" class="hidden">
		<span itemprop="name">{{$model->getTitle()}} {{trans('Game Controller')}}</span>
		<span itemprop="description">{{ strip_tags($model->getLead()) }} {{ strip_tags($model->getBody()) }}</span>
		<span itemprop="brand">r-WASD</span>
		<span itemprop="review" itemtype="https://schema.org/Review" itemscope>
			<span itemprop="author" itemtype="https://schema.org/Person" itemscope>
				<span itemprop="name">r-wasd.com</span>
			</span>
		</span>
		<span itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
			<span itemprop="ratingValue">4</span>
			<span itemprop="reviewCount">1</span>
		</span>
	</span>

	<section class="container-fluid container-md product">
		<h1 class="font-russo-one color-orange text-center text-md-start">{{$model->getTitle()}} {{trans('Game Controller')}}</h1>

		<div class="content p-3 p-md-5 rounded">
			<div class="row">
				<div class="col-md-6 mb-2 position-relative image-section">
					@if($model->hasIndexImage())
						<a data-fslightbox="gallery" href="{{$model->getIndexImageFileUrl('image_viewer')}}">
							<div class="position-absolute opacity-25 caption">
								<i class="fa fa-arrows-alt color-blue"></i>
							</div>
							<img src="{{$model->getIndexImageFileUrl('page')}}" class="img-fluid w-100" alt="{{$model->getTitle()}}" />
						</a>
					@endif

					@if($model->images->count())
						@foreach($model->images as $productImage)
							<a data-fslightbox="gallery" href="{{$productImage->getImageFileUrl('image_viewer')}}" class="hidden"></a>
						@endforeach
					@endif
				</div>
				<div class="col-md-6 font-exo-2 color-gray">
					{!! $model->getLead() !!}

					<form method="post" action="{{url(route('cart_set'))}}">
						{{csrf_field()}}
						<input type="hidden" name="product_id" value="{{$model->id}}" >
						<input type="number" name="amount" value="1" min="1" max="1" class="form-control hidden" />

						<div class="row mt-5 mb-5 text-end justify-content-center align-items-center">
							<div class="col-6 col-md-10 text-center text-md-end">
								<button type="submit" class="btn btn-default color-blue add-to-cart">
									<i class="fa fa-cart-plus"></i> Add to cart
								</button>
							</div>
							<div class="col-6 col-md-2 text-center text-md-start">
								<span class="price font-exo-2 color-orange">${!! number_format($model->price, 2, '.', ',') !!}</span>
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