<header>
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">r-WASD</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item ml-auto">
                        <a class="nav-link @if(url()->current() === url('/')) active @endif" href="{{url('/')}}#products">
                            <i class="fa fa-trademark"></i> {{trans('Products')}}
                        </a>
                    </li>
                    <li class="nav-item ml-md-2 ">
                        <a class="nav-link @if(url()->current() === url('/page/terms-and-conditions')) active @endif" href="{{url(route('page', ['slug' => 'terms-and-conditions']))}}">
                            {{trans('Terms and conditions')}}
                        </a>
                    </li>
                    <li class="nav-item ml-md-2">
                        <a class="nav-link @if(url()->current() === url('/cart')) active @endif" href="{{url('/cart')}}" tabindex="-1" aria-disabled="true">
                            <i class="fa fa-shopping-cart"></i> {{trans('Cart')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>