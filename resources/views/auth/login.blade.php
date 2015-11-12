@extends('admin')


@section('body')
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.users.title.login') }}</h3>
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

						<div class="form-group">
							{!! FORM::label(trans('admin.users.field.email')) !!}
							{!! FORM::text('email', old('email'), ['class'=>'form-control']) !!}
						</div>

						<div class="form-group">
							{!! FORM::label('Mot de passe') !!}
							{!! FORM::password('password', ['class'=>'form-control']) !!}
						</div>

						<div class="form-group">
							{!! FORM::checkbox('remember', old('remember'), NULL, array('id' => 'remember')) !!}
							{!! FORM::label('remember', trans('admin.users.message.remember_me')) !!}
						</div>

						<div class="form-group">
							{!! Form::submit(trans('admin.users.action.login'), ['class'=>'btn btn-success  btn-block'] ) !!}
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@stop