@extends('adminlte::page')
@section('content_header')
    <h1>{{trans('Product')}}: @if($model->id) {{$model->title}} [{{$model->id}}] @else {{trans('New')}} @endif</h1>
@stop

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        @include('admin.layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general_data" data-toggle="tab" aria-expanded="true">{{trans('General data')}}</a></li>

                    @foreach (config('app.languages') as $lang)
                        <li class=""><a href="#{{$lang}}_data" data-toggle="tab" aria-expanded="false">{{trans('' . $lang)}}</a></li>
                    @endforeach

                    <li><a href="#gallery_data" data-toggle="tab" aria-expanded="true">{{trans('Gallery')}}</a></li>
                </ul>
                <div class="tab-content">
                    @include('admin.products.tab_general')
                    @include('admin.products.tab_translates')
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('admin_products_list'))}}" class="btn btn-default">{{trans('Back')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('Save')}}</button>
            </div>
        </div>
    </form>
@endsection

@section('adminlte_js')
    <script type="text/javascript">
        //$('textarea.wysig').wysihtml5();
    </script>
@endsection