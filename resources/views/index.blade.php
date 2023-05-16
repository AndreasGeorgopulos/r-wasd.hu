@extends('layouts.index')
@section('content')

    <!-- Background video -->
    <div class="video-background-holder">
        <div class="video-background-overlay"></div>

        <video id="index-video" playsinline="playsinline" autoplay="autoplay" muted="muted">
            @foreach(\App\Models\IndexVideo::getActiveVideos() as $indexVideo)
                <source src="{{$indexVideo->getSrc()}}" type="video/mp4">
            @endforeach
        </video>

        <div class="video-background-content container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white">
                    <h1 class="display-4">{{strip_tags($indexTitleContentBlock)}}</h1>
                    <p class="lead mb-0 mt-4">{!! $indexLeadContentBlock !!}</p>
                    <p>
                        <a href="{{url(route('main-page'))}}#products" class="text-white products-link">
                            <i class="fa fa-angle-double-down"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <a id="products"></a>
    @if(!empty($pageContentBlock_1))
        <section class="wrapper bg-light bg-opacity-85 pt-5 pb-5">
            <section class="container index">
                {{$pageContentBlock_1}}
            </section>
        </section>
    @endif

    @foreach($products as $index => $model)
        @if($index % 2 == 0)
            <section class="wrapper bg-light bg-opacity-85 pt-5 pb-5">
                <section class="container index">
                    <div class="product-item">
                        <div class="row">
                            <div class="col-md-5 text-center">
                                @if($model->hasIndexImage())
                                    <img src="{{$model->getIndexImageFileUrl('index')}}" class="img-responsive" alt="{{$model->getTitle()}}" />
                                @endif
                            </div>
                            <div class="col-md-7 pt-3">
                                <h2 class="font-russo-one color-orange text-center text-md-start">{{$model->getTitle()}}</h2>
                                <p class="font-exo-2 color-blue">{!! $model->getLead() !!}</p>
                                <p class="text-center text-md-start">
                                    <a href="{{url(route('product', ['slug' => $model->getSlug()]))}}" class="btn bg-color-orange text-white">
                                        {{trans('More info')}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        @else
            <section class="wrapper bg-dark bg-opacity-85 pt-5 pb-5">
                <section class="container index">
                    <div class="product-item">
                        <div class="row">
                            <div class="col-md-5 text-center order-md-last">
                                @if($model->hasIndexImage())
                                    <img src="{{$model->getIndexImageFileUrl('index')}}" class="img-responsive" alt="{{$model->getTitle()}}" />
                                @endif
                            </div>
                            <div class="col-md-7 pt-3">
                                <h2 class="font-russo-one color-orange text-center text-md-start">{{$model->getTitle()}}</h2>
                                <p class="font-exo-2 color-blue">{!! $model->getLead() !!}</p>
                                <p class="text-center text-md-start">
                                    <a href="{{url(route('product', ['slug' => $model->getSlug()]))}}" class="btn bg-color-orange text-white">
                                        {{trans('More info')}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        @endif
    @endforeach

    @if(!empty($pageContentBlock_2))
        <section class="wrapper bg-light bg-opacity-85 pt-5 pb-5">
            <section class="container index">
                {{$pageContentBlock_2}}
            </section>
        </section>
    @endif

@endsection
