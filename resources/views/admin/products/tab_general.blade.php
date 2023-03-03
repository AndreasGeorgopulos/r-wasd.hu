<div class="tab-pane active" id="general_data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{trans('Title')}}*</label>
                <input type="text" name="title" class="form-control" value="{{old('title', $model->title)}}" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{trans('Price')}}*</label>
                <input type="text" name="price" class="form-control" value="{{old('price', $model->price)}}" />
            </div>
        </div>
    </div>

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
                    <ul>
                        <li><a href="{{asset($model->getIndexImageFileUrl())}}" target="iframe_index_image">Original</a></li>
                        @foreach($model->indexImageConfig['resizes'] as $key => $config)
                            <li><a href="{{asset($model->getIndexImageFileUrl($key))}}" target="iframe_index_image">{{\Illuminate\Support\Str::title($key)}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    <img src="{{asset($model->getIndexImageFileUrl('page'))}}" />
                </div>
            @endif
        </div>
    </div>
</div>