@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Orders')}}</h1>
	@include('admin.orders._tabs')
@stop

@section('js')
	<script src="{{asset('/js/admin.js')}}"></script>
@endsection

@section('content')
	@include('admin.layout.table.index')
@endsection