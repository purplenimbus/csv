@extends('layouts.app')

@section('content')
<div uk-grid>
	<div class="uk-width-1-3@m center-block">
		<div class="uk-card uk-card-default">
			<div class="uk-card-header">
				<div class="uk-card-title">{{ __('Login') }}</div>
			</div>

			<div class="uk-card-body uk-padding-small">
				<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
					@csrf

					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon" uk-icon="icon: mail"></span>
							<input id="email" type="email" class="uk-input {{ $errors->has('email') ? 'uk-form-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
						</div>
						@if ($errors->has('email'))
							<span class="invalid-feedback uk-text-small uk-text-danger" role="alert">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					
					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon" uk-icon="icon: lock"></span>
							<input id="password" type="password" class="uk-input {{ $errors->has('password') ? 'uk-form-danger' : '' }}" name="password" required>
						</div>
						@if ($errors->has('password'))
							<span class="invalid-feedback uk-text-small uk-text-danger" role="alert">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div class="uk-margin uk-width-1-1">
						<div class="form-check">
							<input class="uk-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

							<label class="uk-form-label" for="remember">
								{{ __('Remember Me') }}
							</label>
						</div>
					</div>

					<div class="uk-margin uk-width-1-1">
						<button type="submit" class="uk-button uk-button-primary">
							{{ __('Login') }}
						</button>

						<a class="uk-btn uk-btn-link" href="{{ route('password.request') }}">
							{{ __('Forgot Your Password?') }}
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
