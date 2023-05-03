<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<style>
		body {
			font-family: "sans-serif";
			font-size: 16px;
			color: #222222;
		}

		.header {
			background-color: #fe784f !important;
			color: #ffffff;
			font-size: 12px;
		}

		.header table {
			padding: 0;
			margin: 0;
			width: 100%;
		}
		.header table td.logo {
			width: 38%;
		}
		.header table td.seller-info {
			width: 38%;
		}
		.header table td.order-info {
			width: 24%;
		}

		h3 {
			color: #3396a8;
		}

		.text-left {
			text-align: left;
		}

		.text-center {
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		.bill-to {
			border: solid 1px #222222;
			border-top:  none;
			vertical-align: top;
			padding: 0px 10px 0px 10px;
		}

		.ship-to {
			border: solid 1px #222222;
			border-top:  none;
			border-left:  none;
			vertical-align: top;
			padding: 0px 10px 10px 10px;
		}

		.products {
			border: solid 1px #222222;
			border-top: none;
			padding: 0px 10px 10px 10px;
		}

		.products table {
			padding: 0;
			margin: 0;
			width: 100%;
		}

		.products table th {
			margin: 0;
			border-bottom: solid 1px #222222;
			padding-bottom: 5px;
			color: #222222;
		}

		.products table td {
			margin: 0;
			padding: 8px 0px 8px 0px;
		}

		.products table tfoot td.total-pay {
			font-weight: bold;
			font-size: 18px;
			border-top: solid 1px #222222;
		}

		footer {
			font-size: 14px;
			position: absolute;
			bottom: 0px;
			text-align: center;
			width: 100%;
			border-top: solid 1px #222222;
			padding-top: 10px;
		}
	</style>
</head>
<body>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="header" colspan="2">
				<table>
					<tr>
						<td class="logo">
							<img src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('/images/logo.png')))}}" />
						</td>
						<td class="seller-info">
							{{$company['name']}}<br/>
							{{$company['address']}}, {{$company['country']}}<br/>
							{{$company['email']}}
						</td>
						<td class="order-info">
							Order ID: {{$order->order_code}}<br/>
							Date: {{date('d/m/Y', strtotime($order->created_at))}}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="bill-to">
				<h3>{{trans('Bill to')}}</h3>
				<p>{{$order->name}}</p>
				<p>{{$order->shipping_zip}} {{$order->shipping_city}}, {{$order->shipping_address}}, {{$order->shipping_country->name}}</p>
				<p>{{$order->email}}</p>
				<p>{{$order->phone}}</p>
			</td>
			<td class="ship-to">
				<h3>{{trans('Ship to')}}</h3>
				<p>{{$order->name}}</p>
				<p>{{$order->shipping_zip}} {{$order->shipping_city}}, {{$order->shipping_address}}, {{$order->shipping_country->name}}</p>
			</td>
		</tr>
		<tr>
			<td class="products" colspan="2">
				<h3 class="text-center">{{trans('Items of order')}}</h3>
				<table cellspacing="0" cellpadding="0">
					<thead>
					<tr>
						<th class="text-left">{{trans('Description')}}</th>
						<th class="text-center">{{trans('Quantity')}}</th>
						<th class="text-right">{{trans('Unit price')}}</th>
						<th class="text-right">{{trans('Total')}}</th>
					</tr>
					</thead>

					<tbody>
					@foreach($order->order_items as $orderItem)
						<tr>
							<td class="text-left">{{$orderItem->product->title}}</td>
							<td class="text-center">{{$orderItem->amount}}</td>
							<td class="text-right">${{number_format($orderItem->unit_price, 2)}}</td>
							<td class="text-right">${{number_format($orderItem->getTotal(), 2)}}</td>
						</tr>
					@endforeach
					</tbody>

					<tfoot>
					<tr>
						<td colspan="3" class="text-right">{{trans('Subtotal')}}:</td>
						<td class="text-right">${{number_format($order->getSubTotal(), 2)}}</td>
					</tr>
					<tr>
						<td colspan="3" class="text-right">{{trans('Postal fee')}}:</td>
						<td class="text-right">${{number_format($order->postal_fee, 2)}}</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td class="text-right total-pay">{{trans('Total pay')}}:</td>
						<td class="text-right total-pay">${{number_format($order->getTotal(), 2)}}</td>
					</tr>
					</tfoot>
				</table>
			</td>
		</tr>
	</table>

	<footer>
		Thank you for your purchasing. Can’t use a proforma invoices to reclaim VAT.
	</footer>
</body>
</html>


