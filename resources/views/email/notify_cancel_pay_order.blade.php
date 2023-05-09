@extends('layouts.email')
@section('content')
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		@include('email.parts.header')
		@include('email.parts.invocation')
		<tr>
			<td>
				We regret to inform you that the payment for your order was <b>unsuccessful</b>.
				<br><br>
				We apologize for any inconvenience caused. Please double-check the payment details
				you provided and ensure that your payment method has sufficient funds or is valid.
				<br><br>
				If you have any questions or need assistance regarding the payment process,
				please don't hesitate to contact our customer support team.
				They will be happy to help you resolve the issue and complete your order successfully.
				<br><br>
				Thank you for your understanding. We apologize for any inconvenience this may have caused.
			</td>
		</tr>
		@include('email.parts.order_info')
		@include('email.parts.signature')
	</table>
@endsection