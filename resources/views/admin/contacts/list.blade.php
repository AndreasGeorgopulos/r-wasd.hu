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
						<th class="@if($sort == 'email') sorting_{{$direction}} @else sorting @endif" data-column="email">{{trans('E-mail')}}</th>
						<th class="text-center">{{trans('Created At')}}</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach ($list as $model)
						<tr role="row" class="odd">
							<td>{{$model->id}}</td>
							<td>{{$model->name}}</td>
							<td>{{$model->email}}</td>
							<td class="text-center">{{date('Y.m.d @H:i', strtotime($model->created_at))}}</td>
							<td>
								<div class="btn-group pull-right">
									<button type="button" class="btn btn-primary btn-sm">{{trans('Operations')}}</button>
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="{{url(route('admin_contacts_view', ['id' => $model->id]))}}">
												<i class="fa fa-eye"></i> {{trans('View')}}
											</a>
										</li>

										<li class="divider"></li>
										<li>
											<a href="{{url(route('admin_contacts_delete', ['id' => $model->id]))}}" data-title="{{$model->name}}">
												<i class="fa fa-trash"></i> {{trans('Delete')}}
											</a>
										</li>
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