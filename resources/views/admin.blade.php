
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

		<title>Starter Template for Bootstrap</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

		<link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">


		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
  	</head>

  	<body style="padding-top: 80px;">
		
		{{-- Init variables for views --}}

		@if (isset(Request::segments()[1])) 
			<?php  $controller = Request::segments()[1] ?>	
		@else
			{{{ $controller = NULL }}}	
		@endif 
  		
  		{{-- / --}}

		<nav class="navbar navbar-inverse navbar-fixed-top">
		 	<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
			  		</button>
			  		<a class="navbar-brand" href="{{ route('admin.index') }}">Administration</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					@if (Auth::check())
				  		<ul class="nav navbar-nav">
							<li class="@if ($controller == NULL) active @endif"><a href="{{ route('admin.index') }}">Home</a></li>
							<li class="@if ($controller == 'pages') active @endif" ><a href="{{ route('admin.pages.index')}}">Pages</a></li>
				  		</ul>
				  	@endif
			  		<ul class="nav navbar-nav navbar-right">
			  			@if (Auth::check())
			  				<li class="dropdown ">
			  					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                   {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                				<ul class="dropdown-menu">
                                    <li><a href="{{ route('logout') }}">Deconnexion</a></li>
                				</ul>
              				</li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @endif
          			</ul>
				</div><!--/.nav-collapse -->
		  	</div>
		</nav>

		<div id="container" class="container">
			@section('container')
				<div class="row">
					<div class="sidebar col-md-2">
						@section('sidebar')
							<h2>Heading</h2>
	              			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
						@show
					</div>

					<div class="content col-md-9 col-md-offset-1">
						@section('content')
							<div class="jumbotron">
						    	<h1>Bankroll</h1>
								<p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
						    	<p>To see the difference between static and fixed top navbars, just scroll.</p>
								<p>
									<a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs »</a>
								</p>
							</div>
					    @show
					</div>
				</div>
			@show
		</div><!-- /.container -->


		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		

  	</body>
</html>
