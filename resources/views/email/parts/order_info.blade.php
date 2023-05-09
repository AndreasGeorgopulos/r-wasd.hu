<tr><td>&nbsp;</td></tr>
<tr><td><hr></td></tr>
<tr><td style="color: #3396a8; font-size: 18px;">{{trans('Order details')}}</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td style="color: #3396a8; font-size: 16px;">{{trans('Bill to')}}</td>
</tr>
<tr>
	<td>
		{{$order->name}}<br>
		{{$order->shipping_zip}} {{$order->shipping_city}}, {{$order->shipping_address}}, {{$order->shipping_country->name}}<br>
		{{$order->email}}<br>
		{{$order->phone}}
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td style="color: #3396a8; font-size: 16px;">{{trans('Ship to')}}</td>
</tr>
<tr>
	<td>
		{{$order->name}}<br>
		{{$order->shipping_zip}} {{$order->shipping_city}}, {{$order->shipping_address}}, {{$order->shipping_country->name}}
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td style="color: #3396a8; font-size: 16px;">{{trans('Items of order')}}</td>
</tr>
<tr>
	<td>
		<table cellspacing="5" cellpadding="5" border="0" style="width: 100%;">
			<tr>
				<th style="text-align: left;">{{trans('Description')}}</th>
				<th style="text-align: center;">{{trans('Quantity')}}</th>
				<th style="text-align: right;">{{trans('Unit price')}}</th>
				<th style="text-align: right;">{{trans('Total')}}</th>
			</tr>

			@foreach($order->order_items as $orderItem)
				<tr>
					<td style="text-align: left;">{{$orderItem->product->title}}</td>
					<td style="text-align: center;">{{$orderItem->amount}}</td>
					<td style="text-align: right;">${{number_format($orderItem->unit_price, 2)}}</td>
					<td style="text-align: right;">${{number_format($orderItem->getTotal(), 2)}}</td>
				</tr>
			@endforeach

			<tr>
				<td colspan="3" style="text-align: right;">{{trans('Subtotal')}}:</td>
				<td style="text-align: right;">${{number_format($order->getSubTotal(), 2)}}</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: right;">{{trans('Postal fee')}}:</td>
				<td style="text-align: right;">${{number_format($order->postal_fee, 2)}}</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td style="text-align: right; font-weight: bold;">{{trans('Total pay')}}:</td>
				<td style="text-align: right; font-size: 16px; color: #fe784f; font-weight: bold;">${{number_format($order->getTotal(), 2)}}</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td style="text-align: center;">
		<a href="{{url(route('order_proform_invoice', ['hash' => md5($order->order_code)]))}}" style="background-color: #fe784f; color: #ffffff; padding: 8px 20px 8px 20px;">
			{{trans('Download proform invoice')}}
		</a>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>

@if(!empty($order->notice))
	<tr>
		<td style="color: #3396a8; font-size: 16px;">{{trans('Notice')}}</td>
	</tr>
	<tr>
		<td>{!! $order->notice !!}}</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
@endif