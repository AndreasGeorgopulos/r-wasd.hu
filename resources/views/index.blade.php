@extends('layouts.index')
@section('content')

    <!-- Background video -->
    <div class="video-background-holder">
        <div class="video-background-overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="{{asset('/images/bcg_video.mp4')}}" type="video/mp4">
        </video>
        <div class="video-background-content container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white">
                    <h1 class="display-4">{{trans('Welcome to R-WASD site')}}</h1>
                    <p class="lead mb-0">With HTML5 Video and Bootstrap 4</p>
                    <p class="lead">Snippet by <a href="https://bootstrapious.com/snippets" class="text-white">
                            <u>Bootstrapious</u></a>
                    </p>
                    <p>
                        <a href="{{url(route('main-page'))}}#products" class="text-white">
                            <u>Link to products</u></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <a id="products"></a>
    @if(!empty($pageContentBlock_1))
        <section class="wrapper bg-light pt-5 pb-5">
            <section class="container index">
                {{$pageContentBlock_1}}
            </section>
        </section>
    @endif

    @foreach($products as $index => $model)
        @if($index % 2 == 0)
            <section class="wrapper bg-light pt-5 pb-5">
                <section class="container index">
                    <div class="product-item">
                        <div class="row">
                            <div class="col-sm-5 text-center">
                                @if($model->hasIndexImage())
                                    <img src="{{$model->getIndexImageFileUrl('index')}}" class="img-responsive" alt="{{$model->getTitle()}}" />
                                @endif
                            </div>
                            <div class="col-sm-7 pt-3">
                                <h2 class="font-russo-one color-orange">{{$model->getTitle()}}</h2>
                                <p class="font-exo-2 color-blue">{!! $model->getLead() !!}</p>
                                <p class="">
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
            <section class="wrapper bg-dark pt-5 pb-5">
                <section class="container index">
                    <div class="product-item">
                        <div class="row">
                            <div class="col-sm-7 pt-3">
                                <h2 class="font-russo-one color-orange">{{$model->getTitle()}}</h2>
                                <p class="font-exo-2 color-blue">{!! $model->getLead() !!}</p>
                                <p class="">
                                    <a href="{{url(route('product', ['slug' => $model->getSlug()]))}}" class="btn bg-color-orange text-white">
                                        {{trans('More info')}}
                                    </a>
                                </p>
                            </div>
                            <div class="col-sm-5 text-center">
                                @if($model->hasIndexImage())
                                    <img src="{{$model->getIndexImageFileUrl('index')}}" class="img-responsive" alt="{{$model->getTitle()}}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        @endif
    @endforeach

    @if(!empty($pageContentBlock_2))
        <section class="wrapper bg-light pt-5 pb-5">
            <section class="container index">
                {{$pageContentBlock_2}}
            </section>
        </section>
    @endif

@endsection
