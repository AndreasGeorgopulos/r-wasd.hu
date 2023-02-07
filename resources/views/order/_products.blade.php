<h2>{{trans('Products')}}</h2>
@foreach($cartData['cart_items'] as $item)
	<div class="card mb-4">
		<div class="card-header">
			<h5>{{$item['name']}}</h5>
		</div>

		<div class="card-body">
			{!! $item['description'] !!}
		</div>

		<div class="card-footer">
			<div class="row">
				<div class="col-4 text-center">
					{{$item['price_formated']}}
				</div>
				<div class="col-4 text-center">
					{{$item['amount']}} {{trans('pieces')}}
				</div>
				<div class="col-4 text-center">
					{{$item['total_formated']}}
				</div>
			</div>
		</div>
	</div>
@endforeach