@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Contact message view')}}: {{$model->name}} [{{$model->id}}]</h1>
@stop

@section('js')
	<script src="{{asset('/js/admin.js')}}"></script>
@endsection

@section('content')
	<div class="box">
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">{{trans('Created at')}}</div>
				<div class="col-md-9">{{date('Y.m.d @H:i', strtotime($model->created_at))}}</div>
			</div>
			<div class="row">
				<div class="col-md-3">{{trans('E-mail')}}</div>
				<div class="col-md-9">{{$model->email}}</div>
			</div>
			<div class="row p-4">
				<div class="col-md-3">{{trans('Phone')}}</div>
				<div class="col-md-9">{{$model->phone}}</div>
			</div>
			<div class="row p-4">
				<div class="col-md-3">{{trans('Subject')}}</div>
				<div class="col-md-9">
					{{collect(\App\Models\Contact::getSubjectDropdownOptions($model->subject))->where('selected', true)->first()['title']}}
				</div>
			</div>
			<div class="row p-4">
				<div class="col-md-3">{{trans('Message')}}</div>
				<div class="col-md-9">{{$model->message}}</div>
			</div>
		</div>

		<div class="box-footer text-center">
			<a href="{{url(route('admin_contacts_list'))}}" class="btn btn-default">{{trans('Back')}}</a>
		</div>
	</div>
@endsection