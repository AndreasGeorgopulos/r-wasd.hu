<div class="tab-pane active" id="general_data">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('Title')}}*</label>
            <input type="text" name="title" class="form-control" value="{{old('title', $model->title)}}" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{trans('Category')}}*</label>
            <input disabled="disabled" type="text" name="title" class="form-control" value="{{old('category', $model->category)}}" />
        </div>
    </div>
    <div class="clearfix"></div>
</div>