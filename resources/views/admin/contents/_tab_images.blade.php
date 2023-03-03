<div class="tab-pane" id="images_data">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>{{trans('Index image')}}*</label>
				<input type="file" name="index_image" class="form-control" />
			</div>

			@if($model->hasIndexImage())
				<div class="form-group">
					<label><input type="checkbox" name="delete_index_image">{{trans('Delete index image')}}*</label>
				</div>
				<div class="form-group">
					<img src="{{asset($model->getIndexImageFileUrl())}}" />
				</div>
			@endif
		</div>
	</div>
</div>