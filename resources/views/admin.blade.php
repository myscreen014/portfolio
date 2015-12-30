
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">

		<title>{{ trans('admin.global.application.name') }}</title>
		
		<link rel="stylesheet" href="{{ elixir('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ elixir('css/admin.all.css') }}">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		@section('body')



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
						<a class="navbar-brand" href="{{ route('admin.index') }}">{{ trans('admin.global.application.name') }}</a>
					</div>
					<!-- /.navbar-header -->

			  		<ul class="nav navbar-top-links navbar-right">
			  			@if (Auth::check())
			  				<li class="dropdown ">
			  					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                   {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                				<ul class="dropdown-menu">
                					<li><a href="{{ route('admin.administrators.edit', Auth::user()->id) }}"><i class="fa fa-user"></i>{{ trans('admin.user.action.profile') }}</a></li>
                                	<li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i>{{ trans('admin.user.action.logout') }}</a></li>
                				</ul>
              				</li>
                        @endif
          			</ul>
					<!-- /.navbar-top-links -->
					<div class="navbar-default sidebar" role="navigation">
						<div class="sidebar-nav navbar-collapse navbar-ex1-collapse collapse" aria-expanded="false">
							<ul class="nav" id="side-menu">
								@foreach(Config::get('administration.components') as $componentName => $componentDefinition)
									<li class="@if (Request::segments()[1] == $componentName) active @endif">
										<?php $route =  $componentDefinition['routes']['index']; ?>	
										<a href="{{ route($route) }}"><i class="fa {{ $componentDefinition['icon'] }}"></i>{{ trans('admin.global.component.'.$componentName.'.index') }}</a>

										@if (isset($componentDefinition['routes']['children']))
											<ul class="nav nav-second-level">
												@foreach($componentDefinition['routes']['children'] as $componentChildName => $componentChildRoute)
													<li class="@if ($controllerName == $componentChildName) active @endif">
														<a href="{{ route($componentChildRoute) }}"><i class="fa fa-angle-right"></i>{{ trans('admin.global.component.'.$componentName.'.'.$componentChildName) }}</a>
													</li>
												@endforeach
											</ul>
										@endif 

									</li>
								@endforeach
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

			<!-- JavaScripts
			================================================== -->
			<script src="{{ elixir('js/admin.all.js') }}"></script>
			<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
			

			@section('javascript')
				<script>
					Admin.init(
					{
						'csrf_token' : "{{ csrf_token() }}",
						'route_models_reorder' : "{{ route('admin.models.reorder') }}",
						'route_models_publish' : "{{ route('admin.models.publish') }}"
					},
					{
						'i18n' : jQuery.parseJSON('<?php print(json_encode(trans('admin'), JSON_HEX_APOS)) ?>')
					});
					//Admin.configInit();
				</script>
			@show
				
		@show
	</body>

</html>

