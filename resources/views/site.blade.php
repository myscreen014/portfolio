
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

		
		<?php $metaTitle = ''; ?>
		@if (isset($_metaTitle))
			<?php $metaTitle = $_metaTitle.' - '; ?>
		@elseif (isset($page))
			@if ($page['meta-title'])
				<?php $metaTitle = $page['meta-title'].' - '; ?>
			@else
				<?php $metaTitle = $page->name.' - '; ?>
			@endif
		@endif
		<title>
			@if (isset($page) && $page->ordering == 0)
				{{ trans('site.global.name') }} - {{ $metaTitle }}
			@else
				{{ $metaTitle }} {{ trans('site.global.name') }}
			@endif	
		</title>

		<?php $metaDescription = ''; ?>
		@if (isset($_metaDescription))
			<?php $metaDescription = $_metaDescription; ?>
		@elseif (isset($page) && $page['meta-description'])
			<?php $metaDescription = $page['meta-description']; ?>
		@endif
		<meta name="description" content="{{ str_limit(rtrim($metaDescription), 160) }}" />

		
		<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ elixir('css/site.all.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/lightbox/css/swipebox.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/vegas-master/vegas.min.css') }}">
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
				<div class="vegas-caption"></div>
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
		<script src="{{ asset('plugins/lightbox/js/jquery.swipebox.min.js') }}"></script>
		<script src="{{ asset('plugins/vegas-master/vegas.min.js') }}"></script>

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
							'src' : "{{ route('picture', ['background', $picture['name']] ) }}",
							'title'   : "{{ $picture['title'] }}",
							'legend'  : "{{ $picture['legend'] }}"
						});
					@endforeach

					$(document).ready(function() {
						
						var vegasSlideshow = $('body').vegas({
						 	delay: 5000,
					        slides: backgroundPictures,
					        transition: 'fade',
					        timer: false,
					        transitionDuration: 1000,
					        animation: [ 'kenburnsUp', 'kenburnsDown', 'kenburnsLeft', 'kenburnsRight' ],
					        overlay: true,
					        walk: function (index, slideSettings) {
					        	if (slideSettings.title != '') {
					        		$('.vegas-caption').html(slideSettings.title);
						        	setTimeout(function() {
							        	$('.vegas-caption').animate({
							        		opacity: 1,
							        	}, 1000, function() {
							        		setTimeout(function() {
							        			$('.vegas-caption').animate({
							        				opacity: 0,
							        			}, 1000);
							        		}, 2500)
							        	})
						        	}, 500);
					        	}
    						}
					    });
					})

				</script>
			@endif 

		@show

	</body>
</html>