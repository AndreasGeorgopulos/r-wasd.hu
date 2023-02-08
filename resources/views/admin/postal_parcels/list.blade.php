<div class="box-body">
	<div class="dataTables_wrapper form-inline dt-bootstrap">
		@include('admin.layout.table.header')
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-striped dataTable">
					<thead>
					<tr role="row">
						<th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
						<th class="@if($sort == 'name') sorting_{{$direction}} @else sorting @endif" data-column="name">{{trans('Name')}}</th>
						<th class="text-center">{{trans('Count of countries')}}</th>
						<th class="text-center @if($sort == 'is_active') sorting_{{$direction}} @else sorting @endif" data-column="is_active">{{trans('Active')}}</th>
						<th>
							<a href="{{url(route('admin_postal_parcels_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Add new postal parcel')}}</a>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($list as $model)
						<tr role="row" class="odd">
							<td>{{$model->id}}</td>
							<td>{{$model->name}}</td>
							<td class="text-center">{{$model->countries->count()}}</td>
							<td class="text-center"><i class="fa @if($model->is_active) fa-check text-green @else fa-lock text-red @endif"></i></td>
							<td>
								<div class="btn-group pull-right">
									<button type="button" class="btn btn-primary btn-sm">{{trans('Operations')}}</button>
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{url(route('admin_postal_parcels_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('Edit')}}</a></li>
										<li class="divider"></li>
										@if($model->isDeletable())
											<li><a href="{{url(route('admin_postal_parcels_delete', ['id' => $model->id]))}}" data-title="{{$model->name}}"><i class="fa fa-trash"></i> {{trans('Delete')}}</a></li>
										@endif
									</ul>
								</div>
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