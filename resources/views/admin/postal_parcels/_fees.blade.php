<h2>{{trans('Fees')}}</h2>
<table class="table table-striped" id="fee-table">
	<thead>
	<tr>
		<th>{{trans('Weight from')}}</th>
		<th>{{trans('Weight to')}}</th>
		<th>{{trans('Fee')}}</th>
		<th class="text-center">{{trans('Delete')}}</th>
	</tr>
	</thead>
	<tbody>
	@foreach($model->fees as $index => $feeModel)
		<tr>
			<td>
				<input type="hidden" name="postal_parcels_fees[{{$index}}][id]" value="{{$feeModel->id}}" />
				<input type="text" name="postal_parcels_fees[{{$index}}][weight_from]" class="form-control input-sm" value="{{$feeModel->weight_from}}" />
			</td>
			<td>
				<input type="text" name="postal_parcels_fees[{{$index}}][weight_to]" class="form-control input-sm" value="{{$feeModel->weight_to}}" />
			</td>
			<td>
				<input type="text" name="postal_parcels_fees[{{$index}}][fee]" class="form-control input-sm" value="{{$feeModel->fee}}" />
			</td>
			<td class="text-center">
				<input type="checkbox" name="postal_parcels_fees[{{$index}}][_delete]" />
			</td>
		</tr>
	@endforeach
	</tbody>
	<thead>
	<tr>
		<td colspan="3"></td>
		<td class="text-center">
			<button type="button" class="btn btn-primary btn-sm btn-add">
				<i class="fa fa-plus"></i>
			</button>
		</td>
	</tr>
	</thead>
</table>