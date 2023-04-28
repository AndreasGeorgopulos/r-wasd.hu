<h3>{{trans('Shipping info')}}</h3>
<table class="table table-striped">
	<tr>
		<th>{{trans('Country')}}:</th>
		<td>{{$model->shipping_country->name}}</td>
	</tr>
	<tr>
		<th>{{trans('Zip')}}:</th>
		<td>{{$model->shipping_zip}}</td>
	</tr>
	<tr>
		<th>{{trans('City')}}:</th>
		<td>{{$model->shipping_city}}</td>
	</tr>
	<tr>
		<th>{{trans('Address')}}:</th>
		<td>{{$model->shipping_address}}</td>
	</tr>
	<tr>
		<th>{{trans('Postal parcel')}}:</th>
		<td>{{$model->postal_parcel->name}}</td>
	</tr>
	<tr>
		<th>{{trans('Postal fee')}}:</th>
		<td>${{$model->postal_fee}}</td>
	</tr>
	<tr>
		<th>{{trans('Postal tracking code')}}:</th>
		<td>
			@if($model->status == \App\Models\Order::STATUS_NEW)
				<input type="text" name="postal_tracking_code" class="form-control" value="{{$model->postal_tracking_code}}" required="required" />
			@else
				{{$model->postal_tracking_code}}
			@endif
		</td>
	</tr>
	<tr>
		<th>{{trans('Notice for shipping')}}:</th>
		<td>
			@if($model->status == \App\Models\Order::STATUS_NEW)
				<textarea name="postal_notice" class="form-control">{{$model->postal_notice}}</textarea>
			@else
				{{$model->postal_notice}}
			@endif
		</td>
	</tr>
	@if($model->status != \App\Models\Order::STATUS_NEW)
		<tr>
			<th>{{trans('Notice for finish')}}:</th>
			<td>
				@if($model->status == \App\Models\Order::STATUS_SENT)
					<textarea name="finish_notice" class="form-control">{{$model->finish_notice}}</textarea>
				@elseif($model->status == \App\Models\Order::STATUS_DONE)
					{{$model->finish_notice}}
				@endif
			</td>
		</tr>
	@endif
</table>