<footer class="footer pt-4 pb-1 mb-0 text-white-50">
    <div class="container">
        <div class="row">
            <section class="col-lg-6 pb-3">
                <h2 class="text-size-3-2-vmax">r-wasd.com</h2>
                <p class="mb-2"><a href="{{url(route('main-page'))}}">{{trans('Products')}}</a></p>
                <p class="mb-2"><a href="{{url(route('page', ['slug' => 'terms-and-conditions']))}}">{{trans('Terms and conditions')}}</a></p>
            </section>

            <section class="col-lg-6">
                <h2 class="text-size-3-2-vmax">{{trans('Contact')}}</h2>
                <p class="mb-2">
                    <a href="{{url(route('contact'))}}">{{trans('Write us')}}</a>
                </p>
            </section>
        </div>

        <hr />

        <p>© {{date('Y')}} r-wasd.com. All rights reserved</p>
    </div>
</footer>
