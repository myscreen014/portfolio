
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">
		<title>{{ trans('site.global.name') }}</title>
		
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ elixir('css/site.all.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/lightbox/jquery.fancybox.css') }}">
	</head>

	<body>
		<div class="mask"></div>
		<div class="container">
			@section('body')

				<header>
					<div class="row">
		    			<div class="col-md-4">
		    				<a href="{{ route('page') }}" class="brand">{{ trans('site.global.name') }}</a>
		    			</div>
		    			<nav class="col-md-8">
		    				<ul>
			    				@foreach($site['pages'] as $item)
									<li>
										<a href="{{ route('page', $item->slug) }}" @if (isset($page) && ($item->id == $page->id)) class="active" @endif>{{ $item->name }}</a>
									</li>
								@endforeach
							</ul>
		    			</nav>
		  			</div>
				</header>

				<div id="container">
					@section('content')
					@show
				</div>

			@show
		</div>
		<footer>
			<div class="container">
				<div class="row">
	    			<div class="col-md-12">

	    				{{ trans('site.global.copyright', array(
	    					'year' => \Carbon\Carbon::now()->year,
	    					'name' => trans('site.global.name')
	    				)) }}
	    			</div>
		  		</div>
		  	</div>
		</footer>

		<!-- Include overlays for site
		================================================== -->
		@include('_others.overlays')

		<!-- JavaScripts
		================================================== -->
		<script src="{{ elixir('js/site.all.js') }}"></script>
		<script src="{{ asset('plugins/lightbox/jquery.fancybox.pack.js') }}"></script>

		@section('javascript')

			<script>
				$(document).ready(function() {
					Site.init({
						'i18n' : jQuery.parseJSON('<?php print(json_encode(trans('site'), JSON_HEX_APOS)) ?>')
					});
				});
			</script>

			@if (isset($page) && count($page->pictures)>0)

				<script>
					var backgroundPictures = new Array();
					@foreach($page->pictures as $picture)
						backgroundPictures.push("{{ route('picture', ['background', $picture['name']] ) }}");
					@endforeach
					$(document).ready(function() {
						$('body').backstretch(backgroundPictures, {duration: 3000, fade: 750});
					})
				</script>
			@endif 

		@show

	</body>
</html>