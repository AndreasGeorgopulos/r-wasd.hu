@extends('layouts.email')
@section('content')
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		@include('email.parts.header')
		@include('email.parts.invocation')
		<tr>
			<td>
				Thank you for shopping with {{$companyName}}
				<br><br>
				Thank you for your payment for the order with the reference number <b>{{$order->order_code}}</b>.
				The payment has been processed successfully and paired with the order.
				<br><br>
				Once the order is ready and being packed,
				you will receive a notification email with the tracking number of the package.
			</td>
		</tr>
		@include('email.parts.order_info')
		@include('email.parts.signature')
	</table>
@endsection