<div class="col-md-6">
    <div class="form-group">
        <label>{{trans('Firstname')}}</label>
        <input type="text" name="firstname" class="form-control" value="{{old('firstname', $model->firstname)}}" />
    </div>
    <div class="form-group">
        <label>{{trans('Lastname')}}</label>
        <input type="text" name="lastname" class="form-control" value="{{old('lastname', $model->lastname)}}" />
    </div>
    <div class="form-group">
        <label>{{trans('E-mail cím')}}</label>
        <input type="email" class="form-control" name="email" value="{{old('email', $model->email)}}" />
    </div>
    <div class="form-group">
        <label>{{trans('Aktív')}}</label>
        <select class="form-control select2" name="active">
            <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('Igen')}}</option>
            <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('Nem')}}</option>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>{{trans('Jelszó')}}</label>
        <input type="password" class="form-control" name="password" placeholder="" />
    </div>
    <div class="form-group">
        <label>{{trans('Jelszó megerősítés')}}</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="" />
    </div>
</div>

<div class="clearfix"></div>