
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
		
		<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ elixir('css/site.all.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/lightbox/jquery.fancybox.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

	</head>

	<body>

		<div id="global" class="container-fluid">
			<div class="row">
				<div id="sidebar" class="col-md-2 col-sm-3">
					<a href="{{ route('page') }}" class="brand">{!! trans('site.global.name') !!}</a>
					<div class="spacer"></div>
    				<ul class="clearfix">
	    				@foreach($site['pages'] as $item)
							<li>
								<a href="{{ route('page', $item->slug) }}" @if (isset($page) && ($item->id == $page->id)) class="active" @endif>{{ $item->name }}</a>
							</li>
						@endforeach
					</ul>
					<footer>
						<a href=""><i class="fa fa-facebook-square"></i></a>
						<a href=""><i class="fa fa-twitter-square"></i></a>
						<div class="spacer"></div>
	    				{{ trans('site.global.copyright', array(
	    					'year' => \Carbon\Carbon::now()->year,
	    					'name' => trans('site.global.name')
	    				)) }}
					</footer>
				</div>
				<div id="content" class="col-md-offset-2 col-md-10 col-sm-offset-3 col-sm-9">
					@section('content')
					@show
				</div>
			</div>

		</div>

		

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
						backgroundPictures.push({
							'picture' : "{{ route('picture', ['background', $picture['name']] ) }}",
							'title'   : "{{ $picture['title'] }}",
							'legend'  : "{{ $picture['legend'] }}"
						});
					@endforeach
					$(document).ready(function() {
						var options = {
	            			fade: 700,
	            			duration: 6000
	        			};
						var pictures = $.map(backgroundPictures, function(i) { return i.picture; });

						$.backstretch(pictures, {duration: options.duration, fade: options.fade});

						$(window).on("backstretch.show", function(e, instance) {
							var title = backgroundPictures[instance.index].title;
							var legend = backgroundPictures[instance.index].legend;

							var caption = '';
							if (title!='') caption+='<span class="title">'+title+'</span>';
							if (legend!='') caption+='<span class="legend">'+legend+'</span>';
							if (caption!='') $(".backstretch-caption").html(caption).addClass('current');
						});
						$(window).on("backstretch.before", function(e, instance) {
							$(".backstretch-caption").removeClass('current');
						});
					})

				</script>
			@endif 

		@show

	</body>
</html>