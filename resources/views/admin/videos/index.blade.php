@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Videos')}}</h1>
@stop

@section('js')
	<script src="{{asset('/js/admin.js')}}"></script>
@endsection

@section('content')
	@include('admin.layout.table.index')
@endsection