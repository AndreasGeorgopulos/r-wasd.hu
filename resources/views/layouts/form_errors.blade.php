@if (session('form_warning_message'))
	<a id="error" class="@if(url()->current() == url('/contact')) contact @endif">
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
	</a>
@endif