@extends('admin')

@section('sidebar')
	
@endsection


@section('content')

	

	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.pages.index')
		
		<h1>{{ trans('admin.pages.title.index') }}</h1>

		@if (count($pages)>0)
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($pages as $page)
						<tr>
							<td>{{ $page->name }}</td>
							<td class="actions">
								<a href="{{ route('admin.pages.show', [$page->id]) }}" class="btn btn-default btn-xs">afficher</a>
								<a href="{{ route('admin.pages.edit', [$page->id]) }}" class="btn btn-primary btn-xs">éditer</a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		@else
			<div class="alert alert-danger" role="alert">
				{{trans('admin.pages.message.nocontent') }}
			</div>
		@endif
		<a href="{{ route('admin.pages.create') }}" class="btn btn-success">Ajouter une page</a>

	@endif

	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.pages.create')
		
		<h1>{{ trans('admin.pages.title.create') }}</h1>

		{!! form($form) !!}

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.pages.edit')
		
		<h1>{{ trans('admin.pages.title.edit') }}</h1>

		{!! form($form) !!}

	@endif


	{{-- SHOW --}}
	@if (Route::currentRouteName() == 'admin.pages.show')
		
		<h1>Affichage d'une page</h1>
		
		<div class="panel panel-default">
  			<div class="panel-body">
				@foreach($page->getFillable() as $attribut)
					<h2>{{ trans('admin.pages.field.'.$attribut) }}</h2>
					<div>{{ $page->$attribut }}</div>
				@endforeach
			</div>
		</div>

		<div class="form-group">
			{!! Form::model($page, array('route' => array('admin.pages.destroy', $page->id), 'method' => 'DELETE')) !!}
				<a href="{{ route('admin.pages.index') }}" class="btn btn-default">Retour</a>
				{!! Form::submit('Supprimer cette page', ['class'=>'btn btn-danger'] ) !!}
			{!! Form::close() !!}
		</div>

	@endif

@endsection