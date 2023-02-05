<div class="tab-pane active" id="general_data">
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
    <div class="clearfix"></div>
</div>