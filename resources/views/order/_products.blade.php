<h2 class="color-blue">{{trans('Products')}}</h2>
@foreach($cartData['cart_items'] as $item)
	<div class="card mb-4">
		<div class="card-header">
			<h5 class="color-orange text-center text-md-start">{{$item['name']}}</h5>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-3 pb-3 pb-md-0">
					@if(!empty($item['image']))
						<img src="{{$item['image']}}" class="img-thumbnail" alt="{{$item['name']}}" />
					@endif
				</div>
				<div class="col-md-9">{!! $item['description'] !!}</div>
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
@if(empty($cartData['postal_fee']))
	<div class="text-center price color-blue">
		{{trans('Total pay')}}: <span class="color-orange">{{$cartData['total_formated']}}</span> + {{trans('postal fee')}}*
	</div>

	<div class="text-center color-blue mt-3">
		* {{trans('The postal fee depends on the selected country.')}}
	</div>
@else
	<div class="text-center price color-blue">
		{{trans('Total pay')}}: <span class="color-orange">{{$cartData['total_formated']}}</span> + {{trans('postal fee')}}*
	</div>
	<div class="text-center color-blue mt-3">
		* {{trans('Postal fee')}}:
	</div>
@endif