@php($routeName = Route::getFacadeRoot()->current()->getName())

<ul class="nav nav-tabs mt-4" id="order-tabs">
	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'admin_orders_new')) active @endif">
		<a href="{{url( route( 'admin_orders_new' ) )}}" class="nav-link">{{trans('New')}}</a>
	</li>

	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'admin_orders_sent')) active @endif">
		<a href="{{url( route( 'admin_orders_sent' ) )}}" class="nav-link">{{trans('Sent')}}</a>
	</li>
	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'admin_orders_done')) active @endif">
		<a href="{{url( route( 'admin_orders_done' ) )}}" class="nav-link">{{trans('Done')}}</a>
	</li>
</ul>