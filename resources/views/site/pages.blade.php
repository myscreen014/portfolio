@extends('site')


@section('content')
	
	<h1>{{ $page->name }}</h1>

	<div class="wysiwyg">

		
		{!! $page->content !!}

		<h2>Pictures</h2>
		@if (count($page->pictures)>0)
			@foreach($page->pictures as $picture)
				<img src="{{ route('picture', ['portfolio', $picture->name]) }}" />
			@endforeach
		@endif

		<h2>Files</h2>
		@foreach($page->files as $file)
			<img src="{{ route('picture', ['portfolio', $file->name]) }}" />
		@endforeach


	</div>

@endsection

