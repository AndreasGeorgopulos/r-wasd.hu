@extends('layouts.index')
@section('content')
	<section class="container cart">
	@include('order._steps')
		<hr />
		@if(!empty($pageContentBlock))
			<div class="">{!! $pageContentBlock !!}</div>
			<hr />
		@endif
	</section>
@endsection