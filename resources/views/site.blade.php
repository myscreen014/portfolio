
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="favicon.ico">

		<meta name="copyright" content="(c) Eric Tarillon">
		<meta name="author" content="{{ trans('site.global.name') }}">
		<meta name="generator" content="Laravel" />

		<title>
			@if ($page->ordering == 0)
				{{ trans('site.global.name') }} - 
				@if ($page['meta-title'])
					{{ $page['meta-title'] }}
				@else
					{{ $page->name }}
				@endif
			@else
				@if ($page['meta-title'])
					{{ $page['meta-title'] }}
				@else
					{{ $page->name }}
				@endif
				- {{ trans('site.global.name') }}
			@endif			
		</title>
		
		<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ elixir('css/site.all.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/lightbox/jquery.fancybox.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

		{{-- Google analytics --}} 
		@if (Config::get('app.ga_code'))
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  			ga('create', "{{ Config::get('app.ga_code') }}", 'auto');
	  			ga('send', 'pageview');
			</script>
		@endif

	</head>

	<body>

		<div id="global">
			<div id="sidebar">
				<a href="{{ route('page') }}" class="brand">{!! trans('site.global.name') !!}</a>
				<a href="#" id="nav-open-action" class="no-loading">
					<i class="fa fa-bars"></i>
				</a>
				<div class="spacer"></div>
				<nav>
					<a href="#" id="nav-close-action" class="no-loading">
						<i class="fa fa-close"></i>
					</a>
					<ul class="clearfix">
	    				@foreach($site['pages']['primary'] as $item)
							<li>
								<a href="{{ route('page', $item->slug) }}" @if (isset($page) && ($item->id == $page->id)) class="active" @endif>{{ $item->name }}</a>
							</li>
						@endforeach
					</ul>
					@if(count($site['pages']['secondary'])>0)
						<div class="spacer sticky"></div>
						<ul class="clearfix">
		    				@foreach($site['pages']['secondary'] as $item)
								<li>
									<a href="{{ route('page', $item->slug) }}" @if (isset($page) && ($item->id == $page->id)) class="active" @endif>{{ $item->name }}</a>
								</li>
							@endforeach
						</ul>
					@endif
				</nav>
				@section('footer')
					<footer>
						<ul class="social">
							<li><a href=""><i class="fa fa-facebook-square"></i></a></li>
							<li><a href=""><i class="fa fa-twitter-square"></i></a></li>
						</ul>
						<div class="spacer sticky"></div>
						<p class="copyright">
		    				{{ trans('site.global.copyright', array(
		    					'year' => \Carbon\Carbon::now()->year,
		    					'name' => trans('site.global.name')
		    				)) }}
	    				</p>
					</footer>
				@show
			</div>
			<div id="content">
				@section('content')
				@show
				<div id="footer-mobile" class="mobile-only">
					@yield('footer')
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

					/* Backstrech slideshow */
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