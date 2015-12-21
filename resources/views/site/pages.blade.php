@extends('site')


@section('content')
	
	@if ($page->content)
		<div class="wysiwyg mask-content">
			{!! $page->content !!}
		</div>
	@endif
	
@endsection

