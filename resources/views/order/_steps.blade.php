<div class="order_steps">
	@php
		$routeName = \Illuminate\Support\Facades\Route::currentRouteName();
		if (in_array($routeName, ['cart_index'])) {
			$item_1_class = 'active';
			$item_2_class = 'locked';
			$item_3_class = 'locked';
		} elseif (in_array($routeName, ['order_checkout', 'order_checkout_check'])) {
			$item_1_class = 'unlocked';
			$item_2_class = 'active';
			$item_3_class = 'locked';
		} elseif (in_array($routeName, ['order_payment'])) {
			$item_1_class = 'unlocked';
			$item_2_class = 'unlocked';
			$item_3_class = 'active';
		} elseif (in_array($routeName, ['success_payment', 'cancel_payment'])) {
			$item_1_class = 'locked';
			$item_2_class = 'locked';
			$item_3_class = 'active';
		}
	@endphp

	<div class="row">
		<div class="col-sm-4 step text-center {{$item_1_class}}">
			@if($item_1_class === 'unlocked')
				<a href="{{url(route('cart_index'))}}">
					<h3><i class="fa fa-shopping-cart"></i> {{trans('Cart')}}</h3>
				</a>
			@else
				<h3 class="h3"><i class="fa fa-shopping-cart"></i> {{trans('Cart')}}</h3>
			@endif
		</div>

		<div class="col-sm-4 step text-center {{$item_2_class}}">
			@if($item_2_class === 'unlocked')
				<a href="{{url(route('order_checkout'))}}">
					<h3><i class="fa fa-list-alt"></i> {{trans('Checkout')}}</h3>
				</a>
			@else
				<h3 class="h3"><i class="fa fa-list-alt"></i> {{trans('Checkout')}}</h3>
			@endif
		</div>

		<div class="col-sm-4 step text-center {{$item_3_class}}">
			@if($item_3_class === 'unlocked')
				<a href="{{url(route('order_payment'))}}">
					<h3><i class="fa fa-paypal"></i> {{trans('Payment')}}</h3>
				</a>
			@else
				<h3 class="h3"><i class="fa fa-paypal"></i> {{trans('Payment')}}</h3>
			@endif
		</div>
	</div>
</div>