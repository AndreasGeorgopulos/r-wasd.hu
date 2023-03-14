<div class="cart-items p-1 p-md-3">
	<div class="row">
		@foreach($cart_items as $item)
			<div class="col-12">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-4">
								<img src="{{$item['product']['index_image']}}" class="img-thumbnail" alt="{{$item['product']['name']}}" />
							</div>
							<div class="col-8">
								<h5 class="color-orange text-center text-md-start">{{$item['product']['name']}}</h5>
								{!! $item['product']['description'] !!}
								{!! $item['product']['description'] !!}

								<div class="row">
									<div class="col-7">
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
												<div class="col-6 text-end color-orange">
													{{$item['total_formated']}}
												</div>
											</div>
										</form>
									</div>
									<div class="col-5 text-end">
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
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>