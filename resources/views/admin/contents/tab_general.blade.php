<div class="tab-pane active" id="general_data">
    <div class="col-md-9">
        <div class="form-group">
            <label>{{trans('Title')}}*</label>
            <input type="text" name="title" class="form-control" value="{{old('title', $model->title)}}" />
        </div>

        <div class="form-group">
            <label>{{trans('Description')}}*</label>
            <textarea name="description" rows="8" class="form-control">{{old('description', $model->description)}}</textarea>
        </div>

        <div class="form-group hidden">
            <label>{{trans('Category')}}*</label>
            <input disabled="disabled" type="text" name="title" class="form-control" value="{{old('category', $model->category)}}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>{{trans('Type')}}*</label>
            <select name="type" class="form-control select2">
                @foreach(\App\Models\Content::getTypeDropdownItems(old('type', $model->type)) as $item)
                    <option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['title']}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('Active')}}*</label>
            <select name="active" class="form-control select2">
                <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('Yes')}}</option>
                <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('No')}}</option>
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
</div>