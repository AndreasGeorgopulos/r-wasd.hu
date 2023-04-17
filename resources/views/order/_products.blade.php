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

<div class="row">
	<div class="col-6 text-end color-blue price p-1">
		{{trans('Subtotal')}}:
	</div>
	<div class="col-6 text-start color-orange price p-1">
		<span class="color-orange">{{$cartData['subtotal_formated']}}</span>
	</div>
</div>

<div class="row">
	<div class="col-6 text-end color-blue price p-1">
		{{trans('Postal fee')}}:
	</div>
	<div class="col-6 text-start color-orange price p-1" id="payment-postal-fee">
		@if(!empty($cartData['postal_fee'])){{$cartData['postal_fee_formated']}}@endif
	</div>
</div>

<div class="row">
	<div class="col-6 text-end color-blue price p-1">
		{{trans('Total')}}:
	</div>
	<div class="col-6 text-start color-orange price p-1" id="payment-total">
		@if(!empty($cartData['total'])){{$cartData['total_formated']}}@endif
	</div>
</div>