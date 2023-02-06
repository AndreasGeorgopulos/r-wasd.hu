@extends('adminlte::page')
@section('content_header')
	<h1>{{trans('Postal parcel')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('New')}} @endif</h1>
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
							<label>{{trans('Name')}}*:</label>
							<input type="text" class="form-control" name="name" value="{{old('name', $model->name)}}" />
						</div>

						<div class="form-group">
							<label>{{trans('Unit price')}}*:</label>
							<input type="number" class="form-control" name="unit_price" value="{{old('unit_price', $model->unit_price)}}" />
						</div>

						<div class="form-group">
							<label>{{trans('Active')}}:</label>
							<select name="is_active" class="form-control select2">
								<option value="1" @if(old('is_active', $model->is_active) == 1) selected="selected" @endif>{{trans('Yes')}}</option>
								<option value="0" @if(old('is_active', $model->is_active) == 0) selected="selected" @endif>{{trans('No')}}</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>{{trans('Countries')}}*:</label>
							<select name="countries[]" class="form-control select2" multiple>
								@foreach(\App\Models\Country::getDropdownItems() as $country)
									<option value="{{$country['id']}}" @if(in_array($country['id'], $countryIds)) selected="selected" @endif>{{$country['name']}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('admin_postal_parcels_list'))}}" class="btn btn-default">{{trans('Back')}}</a>
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