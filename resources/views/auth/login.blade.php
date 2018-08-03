@extends('layouts.app')

@section('content')
<div class="uk-container">
    <div uk-grid>
        <div class="uk-width-3-4@m">
            <div class="uk-card">
                <div class="uk-card-header">
					<div class="uk-card-title">{{ __('Login') }}</div>
				</div>

                <div class="uk-card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="uk-margin">
                            <label for="email" class="uk-width-1-4@m uk-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="uk-input{{ $errors->has('email') ? 'uk-form-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label for="password" class="uk-width-1-4@m uk-form-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="uk-input {{ $errors->has('password') ? 'uk-form-danger' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div uk-grid>
                            <div class="uk-margin">
                                <div class="form-check">
                                    <input class="uk-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="uk-form-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div uk-grid>
                            <div class="uk-width-3-4@m">
                                <button type="submit" class="uk-button uk-button-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="uk-btn uk-btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
