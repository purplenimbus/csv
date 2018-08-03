<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
        <title>Laravel</title>
		
		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ secure_asset('js/app.js') }}" defer></script>
	
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		
		<!-- Styles -->
		<link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
		<div id="app" class="uk-section uk-section-default uk-padding-remove">
			<list-component class="uk-width-1-1"></list-component>
		</div>
    </body>
</html>
