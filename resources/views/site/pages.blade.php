@extends('site')


@section('content')
	
	<h1>{{ $page->name }}</h1>

	<div class="wysiwyg">
		{!! $page->content !!}

	
		@foreach($page->files as $file)
			
		<img src="{{ route('file', $file->id, 'thumnails') }}" />
			
		@endforeach
	</div>

@endsection

