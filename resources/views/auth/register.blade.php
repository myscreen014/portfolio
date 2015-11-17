@extends('site')


@section('body')
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">

				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{{ trans('admin.users.title.register') }}</h3>
					</div>
					<div class="panel-body">

						@if (isset(Request::segments()[2]) && Request::segments()[2] == 'message')

							<p class="alert alert-warning">{{ $message }}</p>
							<a href={{ route('login') }} class="btn btn-default btn-block">{{ trans('site.users.action.goto_login') }}<a>

						@elseif (isset(Request::segments()[1]) && Request::segments()[1] == 'confirmation')
							 
							<p class="alert alert-success">{{ $message }}</p>
							<a href={{ route('login') }} class="btn btn-success btn-block">{{ trans('site.bankrolls.action.goto_index') }}<a>
							
						@else
							
							@if (isset($message))
								{{ $message }}
							@endif

							{!! Form::open() !!}

								@if (count($errors) > 0)
									<ul class="list-unstyled alert alert-danger">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								@endif

								{!! csrf_field() !!}

								<div class="form-group">
									{!! FORM::label('name', trans('admin.users.field.name')) !!}
									{!! FORM::text('name', old('name'), ['class'=>'form-control']) !!}
								</div>

								<div class="form-group">
									{!! FORM::label('email', trans('admin.users.field.email')) !!}
									{!! FORM::text('email', old('email'), ['class'=>'form-control']) !!}
								</div>

								<div class="form-group">
									{!! FORM::label('password', trans('admin.users.field.password')) !!}
									{!! FORM::password('password', ['class'=>'form-control']) !!}
								</div>

								<div class="form-group">
									{!! FORM::label('password_confirmation', trans('admin.users.field.password_confirmation')) !!}
									{!! FORM::password('password_confirmation', ['class'=>'form-control']) !!}
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">{{ trans('admin.users.action.register') }}</button>
								</div>

							{!! Form::close() !!}

						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection



