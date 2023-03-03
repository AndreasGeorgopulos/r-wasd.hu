<div class="box-body">
    <div class="text-right">
        <a href="{{url(route('admin_contents_resize_index_images'))}}" class="btn btn-default">
            <i class="fa fa-arrows-alt"></i> {{trans('Resize index images')}}
        </a>
        <hr />
    </div>

    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('admin.layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'title') sorting_{{$direction}} @else sorting @endif" data-column="title">{{trans('Title')}}</th>
                        <th class="">{{trans('Description')}}</th>
                        <th class="@if($sort == 'type') sorting_{{$direction}} @else sorting @endif" data-column="type">{{trans('Type')}}</th>
                        <th class="@if($sort == 'active') sorting_{{$direction}} @else sorting @endif text-center" data-column="active">{{trans('Active')}}</th>
                        <th>
                            <a href="{{url(route('admin_contents_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Add new content')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <?php $translate = $model->translates()->where('language_code', App::getLocale())->first(); ?>
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td>{{$model->title}}</td>
                            <td>{{\Illuminate\Support\Str::limit($model->description, 50, '...')}}</td>
                            <td>
                                @if($model->type === \App\Models\Content::TYPE_SITE){{trans('Site')}}
                                @elseif($model->type === \App\Models\Content::TYPE_BLOCK){{trans('Block')}}
                                @elseif($model->type === \App\Models\Content::TYPE_EMAIL){{trans('E-mail')}}
                                @else n/a
                                @endif
                            </td>
                            <td class="text-center">
                                <i class="fa @if($model->active == 1) fa-check text-green @else fa-lock text-red @endif"></i>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm">{{trans('Operations')}}</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url(route('admin_contents_edit', ['id' => $model->id]))}}"><i class="fa fa-edit"></i> {{trans('Edit')}}</a></li>
                                        @if($model->deletable)
                                            <li class="divider"></li>
                                            <li><a href="{{url(route('admin_contents_delete', ['id' => $model->id]))}}" class="confirm"><i class="fa fa-trash"></i> {{trans('Delete')}}</a></li>
                                        @endif
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