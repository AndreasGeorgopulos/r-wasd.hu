@extends('layouts.index')

@section('js')
	<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_CAPTCHA_PUBLIC_KEY') }}"></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('{{ env('GOOGLE_CAPTCHA_PUBLIC_KEY') }}').then(function(token) {
				document.getElementById("recaptcha_token").value = token;
			});
		});
	</script>
@endsection

@section('content')
	<section class="container cart">
	@include('order._steps')
		<form method="post" id="order-form">
			{{csrf_field()}}

			<hr />
			@if(!empty($pageContentBlock_1))
				<div class="">{!! $pageContentBlock_1 !!}</div>
				<hr />
			@endif

			@if (session('form_warning_message'))
				@php($arr = session('form_warning_message'))
				<div class="alert alert-warning alert-dismissible">
					<h4><i class="icon fa fa-warning"></i> {{$arr['title']}}</h4>
					<p>{{$arr['lead']}}</p>
					@if (isset($errors) && count($errors->all()))
						<ul>
							@foreach ($errors->all() as $field => $error)
								<li>{{$error}}</li>
							@endforeach
						</ul>
					@endif
				</div>
			@endif

			<div class="row">
				<div class="col-sm-6 p-4">
					@include('order._products')
				</div>
				<div class="col-sm-6 p-4">
					<h2>{{trans('Contact')}}</h2>

					<div class="form-group mb-3">
						<label>{{trans('Full name')}} *</label>
						<input type="text" name="name" class="form-control" value="{{ old('name', $model->name) }}"  />
						<span class="error text-red"></span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('E-mail')}} *</label>
						<input type="text" name="email" class="form-control" value="{{ old('email', $model->email) }}"  />
						<span class="error text-red"></span>
					</div>

					@if(!$accepted_terms_and_conditions)
						<div class="form-group mb-3">
							<label>{{trans('Confirm e-mail')}} *</label>
							<input type="text" name="confirm_email" class="form-control" value="{{ old('confirm_email', $model->confirm_email) }}"  />
							<span class="error text-red"></span>
						</div>
					@endif

					<div class="form-group mb-3">
						<label>{{trans('Phone')}} *</label>
						<input type="text" name="phone" class="form-control" value="{{ old('phone', $model->phone) }}"  />
						<span class="error text-red"></span>
					</div>

					<h2 class="mt-5">{{trans('Shipping address')}}</h2>

					<div class="form-group mb-3">
						<label>{{trans('Country')}} *</label>
						<select name="shipping_country_id" class="form-control select2" >
							<option value="0"></option>
							@foreach(\App\Models\Country::getDropdownItems(true) as $country)
								<option value="{{ $country['id'] }}" @if(old('shipping_country_id', $model->shipping_country_id) == $country['id']) selected="selected" @endif>{{ $country['name'] }}</option>
							@endforeach
						</select>
						<span class="error text-red"></span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Zip')}} *</label>
						<input type="text" name="shipping_zip" class="form-control" value="{{ old('shipping_zip', $model->shipping_zip) }}"  />
						<span class="error text-red"></span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('City')}} *</label>
						<input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city', $model->shipping_city) }}"  />
						<span class="error text-red"></span>
					</div>

					<div class="form-group mb-3">
						<label>{{trans('Address')}} *</label>
						<input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address', $model->shipping_address) }}"  />
						<span class="error text-red"></span>
					</div>

					<h2 class="mt-5">{{trans('Notice')}}</h2>
					<div class="form-group mb-3">
						<textarea name="notice" class="form-control" rows="6">{{old('notice', $model->notice)}}</textarea>
						<span class="error text-red"></span>
					</div>

					@if(!$accepted_terms_and_conditions)
						<div class="form-group mb-3">
							<label><input type="checkbox" name="accept_term_and_conditions" /> {{trans('I accept Terms and conditions')}}</label>
						</div>
					@endif

					<input type="hidden" name="recaptcha_token" id="recaptcha_token" />
				</div>
			</div>

			<hr />
			@if(!empty($pageContentBlock_2))
				<div class="">{!! $pageContentBlock_2 !!}</div>
				<hr />
			@endif

			<div class="pt-3 pb-4">
				<div class="row">
					<div class="col-6 text-center">
						<a href="{{url(route('cart_index'))}}" class="btn btn-outline-info">
							<i class="fa fa-shopping-cart"></i> {{trans('Cart')}}
						</a>
					</div>
					<div class="col-6 text-center">
						<button type="submit" class="btn btn-outline-primary">
							<i class="fa fa-check"></i> {{trans('Continue')}}
						</button>
					</div>
				</div>
			</div>
		</form>
	</section>
@endsection