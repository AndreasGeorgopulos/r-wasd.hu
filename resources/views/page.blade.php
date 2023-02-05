@extends('layouts.index')
@section('content')
	<section class="container page">
		<h1 class="font-russo-one color-orange">{{$model->meta_title}}</h1>
		<p class="font-exo-2 color-gray">{{$model->lead}}</p>
		<p class="font-exo-2 color-gray">{{$model->body}}</p>
	</section>
@endsection