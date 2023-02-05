@extends('layouts.index')
@section('content')

@foreach($products as $index => $model)
    @if($index % 2 == 0)
        <section class="wrapper bg-light pt-5 pb-5">
            <section class="container index">
                <div class="product-item">
                    <div class="row">
                        <div class="col-sm-5 text-center">
                            <img src="{{asset('images/img_2.png')}}" class="img-responsive" />
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
                            <img src="{{asset('images/img_1.png')}}" class="img-responsive" />
                        </div>
                    </div>
                </div>
            </section>
        </section>
    @endif
@endforeach

@endsection
