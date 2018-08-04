@extends('layouts.app')

@section('content')
<div uk-grid>
	<div class="uk-width-1-3@m center-block">
		<div class="uk-card uk-card-default">
			<div class="uk-card-header">
				<div class="uk-card-title">{{ __('Register') }}</div>
			</div>

			<div class="uk-card-body uk-padding-small">
				<form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
					@csrf

					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
						<span class="uk-form-icon" uk-icon="icon: user"></span>
						<input id="name" type="text" class=" uk-input{{ $errors->has('name') ? 'uk-form-danger' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

						@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
						</div>
					</div>

					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon" uk-icon="icon: mail"></span>
							<input id="email" type="email" class="uk-input {{ $errors->has('email') ? 'uk-form-danger' : '' }}" name="email" value="{{ old('email') }}" required>

							@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon" uk-icon="icon: lock"></span>
							<input id="password" type="password" class="uk-input {{ $errors->has('password') ? 'uk-form-danger' : '' }}" name="password" required>

							@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="uk-margin">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon" uk-icon="icon: lock"></span>
							<input id="password-confirm" type="password" class="uk-input" name="password_confirmation" required>
						</div>
					</div>

					<div class="uk-margin" uk-grid>
						<div class="uk-inline uk-width-1-1">
							<button type="submit" class="uk-button uk-button-primary">
								{{ __('Register') }}
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
