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
	<section class="container cart checkout rounded">
	@include('order._steps')
		<form method="post" id="order-form">
			{{csrf_field()}}

			<hr />
			@if(!empty($pageContentBlock_1))
				<div class="">{!! $pageContentBlock_1 !!}</div>
				<hr />
			@endif

			<div class="row">
				<div class="col-md-6 p-4">
					@include('order._products')
				</div>
				<div class="col-md-6 p-4">
					@include('layouts.form_errors')

					<h2 class="color-blue">{{trans('Contact')}}</h2>

					<div class="form-floating mb-3">
						<input type="text" name="name" class="form-control color-blue" value="{{ old('name', $model->name) }}"  />
						<label>{{trans('Full name')}} *</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="email" class="form-control color-blue" value="{{ old('email', $model->email) }}"  />
						<label>{{trans('E-mail')}} *</label>
					</div>

					@if(!$accepted_terms_and_conditions)
						<div class="form-floating mb-3">
							<input type="text" name="confirm_email" class="form-control color-blue" value="{{ old('confirm_email', $model->confirm_email) }}"  />
							<label>{{trans('Confirm e-mail')}} *</label>
						</div>
					@endif

					<div class="form-floating mb-3">
						<input type="text" name="phone" class="form-control color-blue" value="{{ old('phone', $model->phone) }}"  />
						<label>{{trans('Phone')}} *</label>
					</div>

					<h2 class="mt-5 color-blue">{{trans('Shipping address')}}</h2>

					<div class="form-floating mb-3">
						<select name="shipping_country_id" class="form-control color-blue select2">
							<option value="0"></option>
							@foreach(\App\Models\Country::getDropdownItems(true) as $country)
								<option value="{{ $country['id'] }}" @if(old('shipping_country_id', $model->shipping_country_id) == $country['id']) selected="selected" @endif>{{ $country['name'] }}</option>
							@endforeach
						</select>
						<label>{{trans('Country')}} *</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="shipping_zip" class="form-control color-blue" value="{{ old('shipping_zip', $model->shipping_zip) }}"  />
						<label>{{trans('Zip')}} *</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="shipping_city" class="form-control color-blue" value="{{ old('shipping_city', $model->shipping_city) }}"  />
						<label>{{trans('City')}} *</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="shipping_address" class="form-control color-blue" value="{{ old('shipping_address', $model->shipping_address) }}"  />
						<label>{{trans('Address')}} *</label>
					</div>

					<h2 class="mt-5 color-blue">{{trans('Notice')}}</h2>
					<div class="form-group mb-3">
						<textarea name="notice" class="form-control color-blue" rows="8">{{old('notice', $model->notice)}}</textarea>
					</div>

					@if(!$accepted_terms_and_conditions)
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" name="accept_term_and_conditions" id="accept_term_and_conditions" />
							<label class="form-check-label" for="accept_term_and_conditions">{{trans('I accept')}} <a href="{{url(route('page', ['slug' => 'terms-and-conditions']))}}" target="_blank">{{trans('Terms and conditions')}}</a></label>
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