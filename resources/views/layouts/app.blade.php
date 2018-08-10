<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="">
	@auth
    <div id="app" user-id="{{ Auth::user()->uuid }}">
	@endauth
	
	@guest
	<div id="app">	
	@endguest
		<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
			<nav class="uk-navbar-container" uk-navbar>
				<div class="uk-navbar-left">
					<a class="uk-navbar-item uk-logo" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
				</div>
				<div class="uk-navbar-right">
					<ul class="uk-navbar-nav">
						@guest
							<li>
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
							<li class="uk-hidden">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@else
							<li>
								<a href="{{ url('/logout') }}">Logout</a>
								<a href="#" class="uk-hidden">{{ Auth::user()->name }} <span class="caret"></span></a>
								<div class="uk-navbar-dropdown">
									<ul class="uk-nav uk-navbar-dropdown-nav">
										<li class="uk-active">
											<a href="{{ route('logout') }}"
												onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
												{{ __('Logout') }}</a>
										</li>
										<li>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</li>
									</ul>
								</div>
							</li>
						@endguest
					</ul>
				</div>
			</nav>
		</div>
		<main class="uk-section uk-section-default uk-padding-remove uk-height-viewport">
			@yield('content')
		</main>
    </div>
</body>
</html>
