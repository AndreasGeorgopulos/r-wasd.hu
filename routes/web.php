<?php

Route::match(['get'], '/', 'SiteController@index')->name('main-page');
Route::match(['get'], '/page/{slug}', 'SiteController@page')->name('page');
Route::match(['get'], '/product/{slug}', 'ProductController@getBySlug')->name('product');

Route::get('/cart', 'CartController@index')->name('cart_index');
Route::get('/cart/get', 'CartController@get')->name('cart_get');
Route::post('/cart/set', 'CartController@set')->name('cart_set');

Route::match(['get', 'post'], '/order/proform_invoice/{hash}', 'OrderController@getProFormInvoice')->name('order_proform_invoice');
Route::match(['get', 'post'], '/order/checkout', 'OrderController@checkout')->name('order_checkout');
Route::match(['get', 'post'], '/order/checkout_check', 'OrderController@checkoutCheck')->name('order_checkout_check');
Route::match(['get', 'post'], '/order/payment', 'OrderController@payment')->name('order_payment');
Route::match(['get', 'post'], '/order/success_payment/{order_code}', 'OrderController@successPayment')->name('success_payment');
Route::match(['get', 'post'], '/order/cancel_payment/{order_code}', 'OrderController@cancelPayment')->name('cancel_payment');
Route::match(['get'], '/order/get_postal_fee/{country_id}', 'OrderController@getPostalFee')->name('order_get_postal_fee');

Route::match(['get', 'post'], '/contact', 'SiteController@contact')->name('contact');
Route::match(['get'], '/sitemap.xml', 'SiteController@sitemap')->name('sitemap');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
	Route::match(['get'], '/', function () {
		return redirect(route('login'));
	})->name('admin_index');
	Route::match(['get', 'post'], '/login', 'IndexController@login')->name('login');
	Route::match(['get', 'post'], '/language/{lang}', 'IndexController@changeLanguage')->name('admin_language_change');

	Route::group(['middleware' => ['auth', 'acl', 'locale']], function() {
		/*Route::match(['get'], '/', function () {
			return redirect(route('admin_dashboard'));
		})->name('admin_index_logged_in');*/
		Route::match(['get'], '/dashboard', 'IndexController@dashboard')->name('admin_dashboard');
		Route::match(['get','post'], '/logout', 'IndexController@logout')->name('admin_logout');

		// users
		Route::match(['get', 'post'], '/users', function () {
			return redirect(route('admin_users_list'));
		})->name('admin_users_index');
		Route::match(['get', 'post'], '/users/list', 'UserController@index')->name('admin_users_list');
		Route::match(['get', 'post', 'put'], '/users/edit/{id?}', 'UserController@edit')->name('admin_users_edit');
		Route::match(['get'], '/users/delete/{id?}', 'UserController@delete')->name('admin_users_delete');
		Route::match(['get'], '/users/force_login/{id?}', 'UserController@forceLogin')->name('admin_users_force_login');

		// roles
		Route::match(['get', 'post'], '/roles', function () {
			return redirect(route('admin_roles_list'));
		})->name('admin_roles_index');
		Route::match(['get', 'post'], '/roles/list', 'RoleController@index')->name('admin_roles_list');
		Route::match(['get', 'post', 'put'], '/roles/edit/{id?}', 'RoleController@edit')->name('admin_roles_edit');
		Route::match(['get'], '/roles/delete/{id?}', 'RoleController@delete')->name('admin_roles_delete');

		// contents
		Route::match(['get', 'post'], '/contents', function () {
			return redirect(route('admin_contents_list'));
		})->name('admin_contents_index');
		Route::match(['get', 'post'], '/contents/list', 'ContentController@index')->name('admin_contents_list');
		Route::match(['get', 'post', 'put'], '/contents/edit/{id?}', 'ContentController@edit')->name('admin_contents_edit');
		Route::match(['get'], '/contents/delete/{id?}', 'ContentController@delete')->name('admin_contents_delete');
		Route::match(['get'], '/contents/resize_index_images/{id?}', 'ContentController@resizeIndexImages')->name('admin_contents_resize_index_images');

		// products
		Route::match(['get', 'post'], '/products', function () {
			return redirect(route('admin_products_list'));
		})->name('admin_products_index');
		Route::match(['get', 'post'], '/products/list', 'ProductController@index')->name('admin_products_list');
		Route::match(['get', 'post', 'put'], '/products/edit/{id?}', 'ProductController@edit')->name('admin_products_edit');
		Route::match(['get'], '/products/delete/{id?}', 'ProductController@delete')->name('admin_products_delete');
		Route::match(['get'], '/products/resize_index_images/{id?}', 'ProductController@resizeIndexImages')->name('admin_products_resize_index_images');

		// postal parcels
		Route::match(['get', 'post'], '/postal_parcels', function () {
			return redirect(route('admin_postal_parcels_list'));
		})->name('admin_postal_parcels_index');
		Route::match(['get', 'post'], '/postal_parcels/list', 'PostalParcelController@index')->name('admin_postal_parcels_list');
		Route::match(['get', 'post', 'put'], '/postal_parcels/edit/{id?}', 'PostalParcelController@edit')->name('admin_postal_parcels_edit');
		Route::match(['get'], '/postal_parcels/delete/{id?}', 'PostalParcelController@delete')->name('admin_postal_parcels_delete');

		// countries
		Route::match(['get', 'post'], '/countries', function () {
			return redirect(route('admin_countries_list'));
		})->name('admin_countries_index');
		Route::match(['get', 'post'], '/countries/list', 'CountryController@index')->name('admin_countries_list');
		Route::match(['get', 'post', 'put'], '/countries/edit/{id?}', 'CountryController@edit')->name('admin_countries_edit');
		Route::match(['get'], '/countries/delete/{id?}', 'CountryController@delete')->name('admin_countries_delete');

		// contacts
		Route::match(['get', 'post'], '/contacts', function () {
			return redirect(route('admin_contacts_list'));
		})->name('admin_contacts_index');
		Route::match(['get', 'post'], '/contacts/list', 'ContactController@index')->name('admin_contacts_list');
		Route::match(['get'], '/contacts/view/{id?}', 'ContactController@view')->name('admin_contacts_view');
		Route::match(['get'], '/contacts/delete/{id?}', 'ContactController@delete')->name('admin_contacts_delete');

		// orders
		Route::match(['get', 'post'], '/orders', function () {
			return redirect(route('admin_orders_new'));
		})->name('admin_orders_index');
		Route::match(['get', 'post'], '/orders/new', 'OrderController@indexNew')->name('admin_orders_new');
		Route::match(['get', 'post'], '/orders/sent', 'OrderController@indexSent')->name('admin_orders_sent');
		Route::match(['get', 'post'], '/orders/done', 'OrderController@indexDone')->name('admin_orders_done');
		Route::match(['get', 'post'], '/orders/edit/{id?}', 'OrderController@edit')->name('admin_orders_edit');
		Route::match(['get'], '/orders/delete/{id?}', 'OrderController@delete')->name('admin_orders_delete');
	});
});
