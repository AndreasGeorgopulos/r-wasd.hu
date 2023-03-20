<h2 class="color-blue">{{trans('Products')}}</h2>
@foreach($cartData['cart_items'] as $item)
	<div class="card mb-4">
		<div class="card-header">
			<h5 class="color-orange text-center text-md-start">{{$item['name']}}</h5>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-3">
					@if(!empty($item['image']))
						<img src="{{$item['image']}}" class="img-thumbnail" alt="{{$item['name']}}" />
					@endif
				</div>
				<div class="col-9">{!! $item['description'] !!}</div>
			</div>
		</div>

		<div class="card-footer">
			<div class="row">
				<div class="col-4 text-center">

				</div>
				<div class="col-4 text-center">

				</div>
				<div class="col-4 text-center">
					<span class="price color-orange">{{$item['total_formated']}}</span>
				</div>
			</div>
		</div>
	</div>
@endforeach