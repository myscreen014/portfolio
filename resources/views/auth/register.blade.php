@extends('site')


@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{{ trans('admin.users.title.register') }}</h3>
					</div>
					<div class="panel-body">
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
								{!! FORM::label(trans('admin.users.field.name')) !!}
								{!! FORM::text('name', old('name'), ['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{!! FORM::label(trans('admin.users.field.email')) !!}
								{!! FORM::text('email', old('email'), ['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{!! FORM::label(trans('admin.users.field.password')) !!}
								{!! FORM::password('password', ['class'=>'form-control']) !!}
							</div>

							<div class="form-group">
								{!! FORM::label(trans('admin.users.field.password_confirmation')) !!}
								{!! FORM::password('password_confirmation', ['class'=>'form-control']) !!}
							</div>


							<div class="form-group">
								<button type="submit" class="btn btn-primary">Register</button>
							</div>

						{!! Form::close() !!}
					</div>
			</div>
		</div>
	</div>
@endsection



