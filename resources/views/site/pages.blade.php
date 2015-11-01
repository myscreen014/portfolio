@extends('site')


@section('content')
	
	<h1>{{ $page->name }}</h1>

	<div class="wysiwyg">
		{{ $page->content }}

	
		@foreach($page->files as $file)
			
			@boom($file, 'simple')
			
		@endforeach
	</div>

@endsection

