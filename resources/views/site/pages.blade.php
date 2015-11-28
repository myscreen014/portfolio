@extends('site')


@section('content')
	
	<h1>{{ $page->name }}</h1>

	<div class="wysiwyg">

		
		{!! $page->content !!}


	</div>

@endsection

