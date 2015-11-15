@extends('site')


@section('content')
	
	<h1>{{ $page->name }}</h1>

	<div class="wysiwyg">
		{!! $page->content !!}

	
		@foreach($page->files as $file)
		<img src="{{ route('picture', ['site', $file->name]) }}" />
			
		@endforeach
	</div>

@endsection

