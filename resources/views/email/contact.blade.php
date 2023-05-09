@extends('layouts.email')
@section('content')
	<table cellpadding="0" cellspacing="0" border="0">
		@include('email.parts.header')
		<tr>
			<td style="color: #3396a8; font-size: 18px;">Dear r-Wasd.com,</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>{!! nl2br($contact->message) !!}</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>Best regards,<br>{{$contact->name}}<br>{{$contact->phone}}</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="font-style: italic; font-size: 12px;">This message sent from from contact page of r-Wasd.com</td>
		</tr>
	</table>
@endsection