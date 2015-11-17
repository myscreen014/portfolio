@extends('_emails.skeleton')

@section('content') 

	<p>Content mail test</p>
	<a href="{{ $urlConfirmation }}">{{ $urlConfirmation }}</a>

@endsection