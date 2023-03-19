<div class="tab-pane" id="gallery_data">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>{{trans('Upload index image')}}*</label>
				<input type="file" name="index_image" class="form-control" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>{{trans('Upload gallery images')}}*</label>
				<input type="file" name="images[]" class="form-control" multiple />
			</div>
		</div>
	</div>

	@if($model->hasIndexImage())
		<hr />
		<h3>{{trans('Uploaded index image')}}</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th>{{trans('Image')}}</th>
				<th>{{trans('File name')}}</th>
				<th>{{trans('Mime type')}}</th>
				<th class="text-right">{{trans('Sizes')}}</th>
				<th class="text-center">{{trans('Delete')}}</th>
			</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<img src="{{$model->getIndexImageFileUrl('thumb_admin')}}">
					</td>
					<td>{{$model->index_image_file_name}}</td>
					<td></td>
					<td class="text-right">
						<div class="btn-group pull-right">
							<button type="button" class="btn btn-primary">{{trans('Resizes')}}</button>
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li class="text-start">
									<a href="{{$model->getIndexImageFileUrl()}}" target="_blank">
										<i class="fa fa-picture-o"></i> Original
									</a>
								</li>
								@foreach(config('app.products.index_images.resizes') as $size => $options)
									<li>
										<a href="{{$model->getIndexImageFileUrl($size)}}" target="_blank">
											<i class="fa fa-image"></i>
											{{\Illuminate\Support\Str::title($size)}}:
											[{{$options['width']}}*{{$options['height']}}
											@if($options['aspect_ratio']) aspect ratio @endif]
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</td>
					<td class="text-center">
						<input type="checkbox" name="delete_index_image" />
					</td>
				</tr>
			</tbody>
		</table>
	@endif

	@if($model->images->count())
		<hr />
		<h3>{{trans('Uploaded gallery images')}}</h3>
		<table class="table table-striped">
			<thead>
			<tr>
				<th>{{trans('Image')}}</th>
				<th>{{trans('File name')}}</th>
				<th>{{trans('Mime type')}}</th>
				<th class="text-right">{{trans('Sizes')}}</th>
				<th class="text-center">{{trans('Delete')}}</th>
			</tr>
			</thead>
			<tbody>
			@foreach($model->images as $productImage)
				<tr>
					<td>
						<img src="{{$productImage->getImageFileUrl('thumb_admin')}}">
					</td>
					<td>{{$productImage->file_name}}</td>
					<td>{{$productImage->file_type}}</td>
					<td class="text-right">
						<div class="btn-group pull-right">
							<button type="button" class="btn btn-primary">{{trans('Resizes')}}</button>
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li class="text-start">
									<a href="{{$productImage->getImageFileUrl()}}" target="_blank">
										<i class="fa fa-picture-o"></i> Original
									</a>
								</li>
								@foreach(config('app.products.images.resizes') as $size => $options)
									<li>
										<a href="{{$productImage->getImageFileUrl($size)}}" target="_blank">
											<i class="fa fa-image"></i>
											{{\Illuminate\Support\Str::title($size)}}:
											[{{$options['width']}}*{{$options['height']}}
											@if($options['aspect_ratio']) aspect ratio @endif]
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</td>
					<td class="text-center">
						<input type="checkbox" name="delete_image[]" value="{{$productImage->id}}" />
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
</div>