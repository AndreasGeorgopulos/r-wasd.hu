<div class="box-body">
	<div class="dataTables_wrapper form-inline dt-bootstrap">
		@include('admin.layout.table.header')
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-striped dataTable">
					<thead>
					<tr role="row">
						<th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
						<th>{{trans('Date')}}</th>
						<th>{{trans('Order code')}}</th>
						<th>{{trans('Name')}}</th>
						<th>{{trans('Shipping')}}</th>
						<th>{{trans('Edit')}}</th>
						<th>{{trans('Proform invoice')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($list as $model)
						<tr role="row" class="odd">
							<td>{{$model->id}}</td>
							<td>{{date('Y.m.d @H:i', strtotime($model->created_at))}}</td>
							<td>{{$model->order_code}}</td>
							<td>{{$model->name}}</td>
							<td>{{$model->shipping_country->name}}, {{$model->shipping_zip}} {{$model->shipping_city}}, {{$model->shipping_address}}</td>

							<td class="text-center">
								<a href="{{url(route('admin_orders_edit', ['id' => $model->id]))}}">
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td class="text-center">
								<a href="{{url(route('order_proform_invoice', ['hash' => md5($model->order_code)]))}}" target="_blank">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@include('admin.layout.table.footer')
	</div>
</div>