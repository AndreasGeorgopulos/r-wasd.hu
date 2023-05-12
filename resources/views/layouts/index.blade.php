<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @if( isset( $meta_data ) && is_array( $meta_data ) )
        @foreach( $meta_data as $key => $value )
            @if( strstr( $key, 'og:' ) != '')<meta property="{{$key}}" content="{{$value}}" />
            @else<meta name="{{$key}}" content="{{$value}}" />
            @endif
        @endforeach
        <title>{{$meta_data['title']?:config('app.name')}}</title>
    @endif

    <link rel="shortcut icon" href="{{asset('favicon.ico?t=' . time())}}" />
    <link rel="canonical" href="{{url()->current()}}" />

    <!-- Preloads -->
    {{--<link href="{{asset('css/img/bg_search.png')}}" rel="preload" as="image" />
    <link href="{{asset('css/img/seasons/four_seasons.png')}}" rel="preload" as="image" />
    <link href="{{asset('css/img/seasons/summer.png')}}" rel="preload" as="image" />
    <link href="{{asset('css/img/seasons/winter.png')}}" rel="preload" as="image" />
    <link href="{{asset('https://agrotyre.hu/images/energy/fuel_c.png')}}" rel="preload" as="image" crossorigin="anonymous" />
    <link href="{{asset('https://agrotyre.hu/images/energy/wet_b.png')}}" rel="preload" as="image" crossorigin="anonymous" />
    <link href="{{asset('https://agrotyre.hu/images/energy/noise_2.png')}}" rel="preload" as="image" crossorigin="anonymous"  />
    <link href="{{asset('bootstrap/fonts/function_bold.ttf')}}" rel="preload" as="font" crossorigin="anonymous" />
    <link href="{{asset('bootstrap/fonts/fontawesome-webfont.woff2?v=4.7.0')}}" rel="preload" as="font" crossorigin="anonymous" />
    <link href="{{asset(config('app.frontend_gzip.css.path')) . '?t=' . time()}}" rel="preload" as="style" />
    <link href="{{asset(config('app.frontend_gzip.js.path')) . '?t=' . time()}}" rel="preload" as="script" />--}}

    <!-- Styles -->
<!--    rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"-->
    <link href="{{asset('css/app.css') . '?t=' . time()}}" rel="stylesheet" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('app.google.analytics-tracking-code')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{config('app.google.analytics-tracking-code')}}');
    </script>
</head>
    <body>
        <button type="button" class="btn btn-floating btn-lg bg-color-orange text-white" id="btn-back-to-top">
            <i class="fa fa-arrow-up"></i>
        </button>

        <div class="wrapper">
            @include('layouts.header')
            <main>
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
        @yield('js')

        <!-- Scripts -->
        <script src="{{asset('js/app.js') . '?t=' . time()}}" type="text/javascript" async="async"></script>
        @include('layouts.google_analytics')
        @include('layouts.cookie_consent')
    </body>
</html>
