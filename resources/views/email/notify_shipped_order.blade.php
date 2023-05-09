@extends('layouts.email')
@section('content')
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		@include('email.parts.header')
		@include('email.parts.invocation')
		<tr>
			<td>
				Your shipment was submitted to our service partner MPL (Hungary).
				To find out the latest information on your shipment please click the link below:
				<br>
				<a href="https://www.posta.hu/ugyfelszolgalat/nyomkovetes" style="color: #3396a8;">Tracking Information</a>
				<br><br>
				You also can type in the tracking number <b>{{$order->postal_tracking_code}}</b> on the Magyar Posta website.
				<br><br>
				<b>Please note that it may take some time to update the tracking information
					after the shipment data is submitted to UPS.</b>
				<br>
				If you have any questions or concerns, please feel free to send us an email to the following address:
				<br>
				<a href="{{url(route('contact'))}}" style="color: #3396a8;">{{trans('Contact')}}</a>
				<br><br>
				We would like to thank you for ordering at {{$companyName}} and
				we look forward to helping you out in the future!
			</td>
		</tr>
		@include('email.parts.order_info')
		@include('email.parts.signature')
	</table>
@endsection