@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Contact messages')}}</h1>
@stop

@section('js')
	<script src="{{asset('/js/admin.js')}}"></script>
@endsection

@section('content')
	@include('admin.layout.table.index')
@endsection