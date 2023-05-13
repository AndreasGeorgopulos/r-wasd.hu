<header>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{asset('/images/logo.png')}}" alt="r-WASD.com" class="img-responsive" width="200" height="48" />
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-sm-center" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item ml-auto text-end text-md-start">
                        <a class="nav-link @if(url()->current() === url('/')) active @endif" href="{{url('/')}}#products">
                            {{trans('Products')}}
                        </a>
                    </li>
                    <li class="nav-item ml-auto text-end text-md-start">
                        <a class="nav-link @if(url()->current() === url('/page/about-us')) active @endif" href="{{url(route('page', ['slug' => 'about-us']))}}">
                            {{trans('About us')}}
                        </a>
                    </li>
                    <li class="nav-item ml-auto text-end text-md-start">
                        <a class="nav-link @if(url()->current() === url('/contact')) active @endif" href="{{url(route('contact'))}}">
                            <i class="fa fa-envelope"></i> {{trans('Contact')}}
                        </a>
                    </li>
                    <li class="nav-item ml-auto text-end text-md-start">
                        <a class="nav-link @if(url()->current() === url('/cart')) active @endif" href="{{url('/cart')}}" tabindex="-1" aria-disabled="true">
                            <i class="fa fa-shopping-cart"></i> {{trans('Cart')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>