<div class="box-body">
	<div class="dataTables_wrapper form-inline dt-bootstrap">
		<form method="post" enctype="multipart/form-data" action="{{route('admin_videos_upload')}}">
			{{csrf_field()}}
			<div class="row">
				<div class="col text-center">
					<input type="file" name="video_files[]" multiple class="form-control" accept=".mp4" />
					<button type="submit" class="btn btn-primary btn-sm">Upload videos</button>
				</div>
			</div>
		</form>
		@include('admin.layout.table.header')
		<div class="row">
			<div class="col-sm-12">
				<form method="post" action="{{url(route('admin_videos_reorder'))}}">
					{{csrf_field()}}
					<table class="table table-bordered table-striped dataTable" id="reorderable-table">
						<thead>
						<tr role="row">
							<th>#</th>
							<th>{{trans('Filenév')}}</th>
							<th class="text-center">{{trans('Állapot')}}</th>
							<th class="text-center">{{trans('Törlés')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($list as $model)
							<tr>
								<td class="dragHandle text-center">
									<i class="fa fa-reorder"></i>
									<input type="hidden" name="ids[]" value="{{$model->id}}" />
								</td>
								<td>{{$model->filename}}</td>
								<td class="text-center">
									@if($model->is_active)
										<a href="{{url(route('admin_videos_set_status', ['id' => $model->id]))}}" class="btn btn-sm btn-success">
											<i class="fa fa-check"></i>
										</a>
									@else
										<a href="{{url(route('admin_videos_set_status', ['id' => $model->id]))}}" class="btn btn-sm btn-default">
											<i class="fa fa-ban"></i>
										</a>
									@endif
								</td>
								<td class="text-center">
									<a href="{{url(route('admin_videos_delete', ['id' => $model->id]))}}" class="btn btn-sm btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>

					<button class="btn btn-primary">
						<i class="fa fa-sort"></i> {{trans('Save order')}}
					</button>
				</form>
			</div>
		</div>
		@include('admin.layout.table.footer')
	</div>
</div>

<style>
	.dragHandle {
		cursor: move;
	}

	.onDragClass td {
		border: solid 1px #3C8DBC !important;
		background-color: #6e97af !important;
		color: #ffffff !important;
	}
</style>

<script>
	$(document).ready(function () {
		$('#reorderable-table').tableDnD({
			onDragClass: 'onDragClass',
			dragHandle: '.dragHandle',
			onDrop: function(table, row) {
			}
		});
	});
</script>