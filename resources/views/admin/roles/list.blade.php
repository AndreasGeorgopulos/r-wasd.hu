<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'key') sorting_{{$direction}} @else sorting @endif" data-column="key">{{trans('Kulcs')}}</th>
                        <th data-column="name">{{trans('Név')}}</th>
                        <th data-column="description">{{trans('Leírás')}}</th>
                        <th>
                            <a href="{{url(route('admin_roles_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Új jogosultság')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <?php $translate = $model->translates()->where('language_code', App::getLocale())->first(); ?>
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td>{{$model->key}}</td>
                            <td>{{!empty($translate->name) ? $translate->name : ''}}</td>
                            <td>{{!empty($translate->description) ? $translate->description : ''}}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('Műveletek')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_roles_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('Szerkesztés')}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url(route('admin_roles_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('Törlés')}}</a></li>
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