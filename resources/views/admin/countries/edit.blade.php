@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Country')}}: @if($model->id) {{$model->name}} [{{$model->code}}] @else {{trans('New')}} @endif</h1>
@stop

@section('content')
	<form method="post">
		{{csrf_field()}}
		@include('admin.layout.messages')
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>{{trans('Code')}}*:</label>
							<input type="text" class="form-control" name="code" value="{{old('code', $model->code)}}" />
						</div>

						<div class="form-group">
							<label>{{trans('Name')}}*:</label>
							<input type="text" class="form-control" name="name" value="{{old('name', $model->name)}}" />
						</div>

						<div class="form-group">
							<label>{{trans('Is active')}}:</label>
							<select name="is_active" class="form-control select2">
								<option value="1" @if(old('is_active', $model->is_active) == 1) selected="selected" @endif>{{trans('Yes')}}</option>
								<option value="0" @if(old('is_active', $model->is_active) == 0) selected="selected" @endif>{{trans('No')}}</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('admin_countries_list'))}}" class="btn btn-default">{{trans('Back')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Save')}}</button>
			</div>
		</div>
	</form>
@endsection

@section('adminlte_js')
	<script type="text/javascript">
		$('.select2').select2();
	</script>
@endsection