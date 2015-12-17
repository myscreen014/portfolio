@extends('site')


@section('content')

	<div class="backstretch-caption"></div>
	
	@if ($page->content)
		<div class="wysiwyg mask-content">
			{!! $page->content !!}
		</div>
	@endif
	

@endsection

