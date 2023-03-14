@extends('layouts.index')
@section('content')
	<section class="container-fluid container-md page">
		<h1 class="font-russo-one color-orange text-center text-md-start">{{$model->meta_title}}</h1>

		<div class="content p-3 p-md-5 rounded">
			<p class="font-exo-2 color-gray">{!! $model->lead !!}</p>
			<p class="font-exo-2 color-gray">{!! $model->body !!}</p>
		</div>
	</section>
@endsection