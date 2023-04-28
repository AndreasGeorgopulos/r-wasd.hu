<h3>{{trans('Products')}}</h3>
<table class="table table-striped">
	<thead>
	<tr>
		<th>{{trans('Product')}}</th>
		<th class="text-center">{{trans('Unit price')}}</th>
		<th class="text-center">{{trans('Amount')}}</th>
		<th class="text-right">{{trans('Total')}}</th>
	</tr>
	</thead>

	<tbody>
	@foreach($model->order_items as $orderItem)
		<tr>
			<td>{{$orderItem->product->title}}</td>
			<td class="text-center">${{number_format($orderItem->unit_price, 2)}}</td>
			<td class="text-center">{{$orderItem->amount}}</td>
			<td class="text-right">${{number_format($orderItem->getTotal(), 2)}}</td>
		</tr>
	@endforeach
	</tbody>

	<tfoot>
	<tr>
		<td colspan="3" class="text-right text-bold">{{trans('Subtotal')}}: </td>
		<td class="text-right text-bold">${{number_format($model->getSubTotal(), 2)}}</td>
	</tr>
	<tr>
		<td colspan="3" class="text-right text-bold">{{trans('Postal fee')}}: </td>
		<td class="text-right text-bold">${{number_format($model->postal_fee, 2)}}</td>
	</tr>
	<tr>
		<td colspan="3" class="text-right text-bold text-green">{{trans('Total pay')}}: </td>
		<td class="text-right text-bold text-green">${{number_format($model->getTotal(), 2)}}</td>
	</tr>
	</tfoot>
</table>