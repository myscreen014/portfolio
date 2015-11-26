
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
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ elixir('css/site.all.css') }}">
	</head>

	<body>

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

		@section('javascript')

			<script>
				$(document).ready(function() {
					Site.init();
				});
			</script>
		@show

	</body>
</html>