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
							<label>{{trans('Active')}}:</label>
							<select name="is_active" class="form-control select2">
								<option value="1" @if(old('is_active', $model->is_active) == 1) selected="selected" @endif>{{trans('Yes')}}</option>
								<option value="0" @if(old('is_active', $model->is_active) == 0) selected="selected" @endif>{{trans('No')}}</option>
							</select>
						</div>
						<div class="form-group">
							<label>{{trans('Countries')}}*:</label>
							<select name="countries[]" class="form-control select2" multiple>
								@foreach(\App\Models\Country::getDropdownItems() as $country)
									<option value="{{$country['id']}}" @if(in_array($country['id'], $countryIds)) selected="selected" @endif>{{$country['name']}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						@include('admin.postal_parcels._fees')
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

		const Fees = {
			table: null,

			init: function () {
				this.table = $('#fee-table');
				this.eventHandlers();
			},

			eventHandlers: function () {
				const $this = this;

				$this.table.find('button.btn-add').off('click');
				$this.table.find('button.btn-add').on('click', function () {
					$this.addNewRow();
				});

				$this.table.find('button.btn-remove').off('click');
				$this.table.find('button.btn-remove').on('click', function () {
					$this.removeRow($(this));
				});
			},

			addNewRow: function () {
				const rowIndex = this.table.find('tbody tr').length;

				let td, tr = $('<tr>');

				td = $('<td>');
				td.append($('<input type="text" name="postal_parcels_fees[' + rowIndex + '][weight_from]" class="form-control input-sm" value="" />'))
				tr.append(td);

				td = $('<td>');
				td.append($('<input type="text" name="postal_parcels_fees[' + rowIndex + '][weight_to]" class="form-control input-sm" value="" />'))
				tr.append(td);

				td = $('<td>');
				td.append($('<input type="text" name="postal_parcels_fees[' + rowIndex + '][fee]" class="form-control input-sm" value="" />'))
				tr.append(td);

				td = $('<td class="text-center">');
				td.append('<button type="button" class="btn btn-danger btn-remove btn-sm"><i class="fa fa-minus"></i></button>');
				tr.append(td);

				this.table.find('tbody').append(tr);

				this.eventHandlers();
			},

			removeRow: function (button) {
				button.closest('tr').remove();
				this.eventHandlers();
			},
		};

		Fees.init();

	</script>
@endsection