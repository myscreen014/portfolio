@extends('admin')

@section('content')

	@include ('_others.feedbacks')
	
	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.galleries.index')

		@section('title')
			{{ trans('admin.gallery.title.index') }}
		@endsection

		@if (count($galleries)>0)
			<table class="table table-striped sortable" data-model="gallery">
				<thead>
					<tr>
						<th>{{ trans('admin.gallery.field.name') }}</th>
						<th>{{ trans('admin.gallery.field.category') }}</th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($galleries as $gallery)
						<tr data-item-id="{{ $gallery->id }}">
							<td>{{ $gallery->name }}</td>
							<td>{{ $gallery->category->name }}</td>
							<td class="actions">
								<a href="{{ route('admin.galleries.edit', [$gallery->id]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="{{ route('admin.galleries.delete', [$gallery->id]) }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		@else
			<div class="alert alert-danger" role="alert">
				{{trans('admin.gallery.message.nocontent') }}
			</div>
		@endif

		<div class="actions">
			<a href="{{ route('admin.galleries.create') }}" class="btn btn-success">{{ trans('admin.gallery.action.add') }}</a>
		</div>

	@endif

	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.galleries.create')

		@section('title')
			{{ trans('admin.gallery.title.create') }}
		@endsection

		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.galleries.edit')

		@section('title')
			{{ trans('admin.gallery.title.edit') }} <small> - {{ $gallery->name }}</small>
		@endsection
		
		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.galleries.delete')

		@section('title')
			{{ trans('admin.gallery.title.delete') }} <small> - {{ $gallery->name }}</small>
		@endsection

		<p class="text text-danger">
			{{ trans('admin.gallery.message.delete') }}
		</p>

		<div class="actions">
			{!! Form::model($gallery, array('route' => array('admin.galleries.destroy', $gallery->id), 'method' => 'DELETE')) !!}
				<a href="{{ route('admin.galleries.index') }}" class="btn btn-default">{{ trans('admin.global.action.back') }}</a>
				{!! Form::submit(trans('admin.gallery.action.delete'), ['class'=>'btn btn-danger'] ) !!}
			{!! Form::close() !!}
		</div>

	@endif


@endsection	
