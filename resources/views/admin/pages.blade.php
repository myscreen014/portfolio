@extends('admin')




@section('content')

	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.pages.index')

		@section('title')
			{{ trans('admin.pages.title.index') }}
		@endsection

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
								<a href="{{ route('admin.pages.show', [$page->id]) }}" class="btn btn-default btn-xs">{{ trans('admin.global.action.show') }}</a>
								<a href="{{ route('admin.pages.edit', [$page->id]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="{{ route('admin.pages.delete', [$page->id]) }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
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

		@section('title')
			{{ trans('admin.pages.title.create') }}
		@endsection

		{!! form($form) !!}

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.pages.edit')

		@section('title')
			{{ trans('admin.pages.title.edit') }}
		@endsection
		
		{!! form($form) !!}

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.pages.delete')

		@section('title')
			{{ trans('admin.pages.title.delete') }}
		@endsection

		{!! Form::model($page, array('route' => array('admin.pages.destroy', $page->id), 'method' => 'DELETE')) !!}
			<a href="{{ route('admin.pages.index') }}" class="btn btn-default">Retour</a>
			{!! Form::submit('Supprimer cette page', ['class'=>'btn btn-danger'] ) !!}
		{!! Form::close() !!}

	@endif


	{{-- SHOW --}}
	@if (Route::currentRouteName() == 'admin.pages.show')

		@section('title')
			{{ trans('admin.pages.title.show') }}
		@endsection
	
		<table class="table table-bordered table-show">
			@foreach($page->getFillable() as $attribut)
				<tr>
					<td class="field">{{ trans('admin.pages.field.'.$attribut) }}</td>
					<td class="value">{{ $page->$attribut }}</td>
				</tr>
			@endforeach
		</table>

		<div class="form-group">
			<a href="{{ route('admin.pages.index') }}" class="btn btn-default">Retour</a>
		</div>

	@endif

@endsection
