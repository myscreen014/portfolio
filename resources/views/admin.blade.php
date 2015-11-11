
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Starter Template for Bootstrap</title>
		
		<link rel="stylesheet" href="{{ elixir('css/admin.all.css') }}">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		@section('body')

			{{-- Init variables for views --}}

			@if (isset(Request::segments()[1])) 
				<?php  $controller = Request::segments()[1] ?>	
			@else
				{{{ $controller = NULL }}}	
			@endif 
	  		
	  		{{-- / --}}

			<div id="wrapper">

				<!-- Navigation -->
				<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.html">SB Admin v2.0</a>
					</div>
					<!-- /.navbar-header -->

			  		<ul class="nav navbar-nav navbar-top-links navbar-right">
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
					<!-- /.navbar-top-links -->

					<div class="navbar-default sidebar" role="navigation">
						<div class="sidebar-nav navbar-collapse">
							<ul class="nav" id="side-menu">
								<li class="sidebar-search">
									<div class="input-group custom-search-form">
										<input type="text" class="form-control" placeholder="Search...">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button">
											<i class="fa fa-search"></i>
										</button>
									</span>
									</div>
									<!-- /input-group -->
								</li>
								<li><a href="{{ route('admin.index') }}" class="@if ($controller == NULL) active @endif">Home</a></li>
								<li><a href="{{ route('admin.pages.index')}}" class="@if ($controller == 'pages') active @endif">Pages</a></li>
							</ul>
						</div>
						<!-- /.sidebar-collapse -->
					</div>
					<!-- /.navbar-static-side -->
				</nav>

				<div id="container">
					<div id="container-inner">
						@section('container')

							<div class="row">
								<div class="col-lg-12">
									<h1 class="page-header">
										@section('title')
										@show
									</h1>
									@section('content')
									@show
								</div>
								<!-- /.col-lg-12 -->
							</div>
							
						@show
					</div>
				</div>
				<!-- /#page-wrapper -->

			</div>
			<!-- /#wrapper -->

			<!-- Include modals for admin
			================================================== -->
			@include('_others.modals')

			<!-- Bootstrap core JavaScript
			================================================== -->
			<script src="{{ elixir('js/admin.all.js') }}"></script>
			

			@section('javascript')
			@show
				
		@show
	</body>

</html>

