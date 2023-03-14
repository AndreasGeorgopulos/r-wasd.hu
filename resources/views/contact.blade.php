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
	<section class="container-fluid container-md page">
		<h1 class="font-russo-one color-orange text-center text-md-start">{{trans('Contact')}}</h1>

		<div class="content p-3 p-md-5 row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				@if(session('send_success'))
					{{trans('Your message sent success.')}}
				@else
					<form method="post" action="{{url(route('contact'))}}">
						{{csrf_field()}}

						@include('layouts.form_errors')

						<div class="form-floating mb-4">
							<input type="text" name="name" class="form-control color-blue" value="{{ old('name', '') }}"  />
							<label>{{trans('Full name')}} *</label>
						</div>

						<div class="form-floating mb-4">
							<input type="text" name="email" class="form-control color-blue" value="{{ old('email', '') }}"  />
							<label>{{trans('E-mail')}} *</label>
						</div>

						<div class="form-floating mb-4">
							<input type="text" name="phone" class="form-control color-blue" value="{{ old('phone', '') }}"  />
							<label>{{trans('Phone number')}}</label>
						</div>

						<div class="form-floating mb-4">
							<select name="subject" class="form-control select2 color-blue">
								<option></option>
								@foreach(\App\Models\Contact::getSubjectDropdownOptions(old('subject', null)) as $item)
									<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
								@endforeach
							</select>
							<label>{{trans('Subject')}} *</label>
						</div>

						<div class="form-floating mb-4">
							<textarea name="message" class="form-control color-blue" style="height: 300px;">{{ old('message', '') }}</textarea>
							<label>{{trans('Your message')}} *</label>
						</div>

						<input type="hidden" name="recaptcha_token" id="recaptcha_token" />

						<div class="text-end">
							<button type="submit" class="btn btn-default bg-color-orange text-white">
								<i class="fa fa-send"></i> Send message
							</button>
						</div>
					</form>
				@endif
			</div>
			<div class="col-md-3"></div>
		</div>
	</section>
@endsection