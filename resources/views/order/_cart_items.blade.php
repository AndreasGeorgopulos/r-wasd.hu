<div class="cart-items p-1 p-md-3">
	<div class="row">
		@foreach($cart_items as $item)
			<div class="col-lg-6">
				<div class="card mb-4">
					<div class="card-header">
						<h5 class="color-orange text-center text-md-start">{{$item['product']['name']}}</h5>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-3">
								<img src="{{$item['product']['index_image']}}" class="img-thumbnail" alt="{{$item['product']['name']}}" />
							</div>
							<div class="col-9">{!! $item['product']['description'] !!}</div>
						</div>

						<div class="row">
							<div class="col-3"></div>
							<div class="col-6">
								<form method="post" action="{{url(route('cart_set'))}}">
									{{csrf_field()}}
									<input type="hidden" name="product_id" value="{{$item['product_id']}}" >
									<div class="row">
										<div class="col-5">
											<input type="number" name="amount" value="{{$item['amount']}}" class="form-control" />
										</div>
										<div class="col-1">
											<button type="submit" class="btn btn-default">
												<i class="fa fa-check"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class="col-3 text-end">
								<form method="post" action="{{url(route('cart_set'))}}" class="text-end">
									{{csrf_field()}}
									<input type="hidden" name="product_id" value="{{$item['product_id']}}" >
									<input type="hidden" name="amount" value="0" class="form-control" />
									<button type="submit" class="btn btn-danger">
										<i class="fa fa-minus"></i>
									</button>
								</form>
							</div>
						</div>
					</div>

					<div class="card-footer">
						<div class="row">
							<div class="col-4 text-center">
								{{$item['product']['price_formated']}}
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
			</div>
		@endforeach
	</div>
</div>