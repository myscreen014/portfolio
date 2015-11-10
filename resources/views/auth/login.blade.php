@extends('admin')


@section('container')

<div class="row">

	<div class="col-md-4 col-md-offset-4">

		<h1>Connexion</h1>

		{!! Form::open() !!}

			{!!  Form::token() !!}

			<div class="form-group">
				{!! FORM::label(trans('admin.users.field.email')) !!}
				{!! FORM::text('email', old('email'), ['class'=>'form-control']) !!}
			</div>

			<div class="form-group">
				{!! FORM::label('Mot de passe') !!}
				{!! FORM::password('password', ['class'=>'form-control']) !!}
			</div>

			<div class="form-group">
				{!! FORM::checkbox('remember') !!}
				{!! FORM::label('Se souvenir de moi') !!}
			</div>

			<div class="form-group">
				{!! Form::submit('Click Me!', ['class'=>'btn btn-primary'] ) !!}
			</div>

		{!! Form::close() !!}

	</div>

</div>

@stop;