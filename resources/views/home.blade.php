@extends('layouts.app')

@section('content')
	@if (session('status'))
		<div class="alert alert-success" role="alert">
			{{ session('status') }}
		</div>
	@endif		
	<list-component class="uk-width-1-1"></list-component>
@endsection
