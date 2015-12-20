@extends('admin')

@section('content')

	@include ('_others.feedbacks')
	
	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.galleries.categories.index')

		@section('title')
			{{ trans('admin.galleriescategory.title.index') }}
		@endsection

		@if (count($categories)>0)
			<table class="table sortable publishable" data-model="galleriescategory">
				<thead>
					<tr>
						<th></th>
						<th>{{ trans('admin.galleriescategory.field.name') }}</th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>

					@foreach($categories as $category)
						<tr data-item-id="{{ $category->id }}" class="publish-{{ $category->publish }}">
							<td class="publish">
								<a href="#"><i class="fa fa-square"></i></a>
							</td>
							<td>{{ $category->name }}</td>
							<td class="actions">
								<a href="{{ route('admin.galleries.categories.edit', [$category->id]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="{{ route('admin.galleries.categories.delete', [$category->id]) }}" class="btn btn-danger btn-xs @if (count($category->galleries)>0) disabled @endif>"> {{ trans('admin.global.action.delete') }}</a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		@else
			<div class="alert alert-danger" role="alert">
				{{ trans('admin.galleriescategory.message.nocontent') }}
			</div>
		@endif

		<div class="actions">
			<a href="{{ route('admin.galleries.categories.create') }}" class="btn btn-success">{{ trans('admin.galleriescategory.action.add') }}</a>
		</div>

	@endif

	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.galleries.categories.create')

		@section('title')
			{{ trans('admin.galleriescategory.title.create') }}
		@endsection

		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.galleries.categories.edit')

		@section('title')
			{{ trans('admin.galleriescategory.title.edit') }} <small> - {{ $category->name }}</small>
		@endsection
		
		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.galleries.categories.delete')

		@section('title')
			{{ trans('admin.galleriescategory.title.delete') }} <small> - {{ $category->name }}</small>
		@endsection

		<p class="text text-danger">
			{{ trans('admin.galleriescategory.message.delete') }}
		</p>

		<div class="actions">
			{!! Form::model($category, array('route' => array('admin.galleries.categories.destroy', $category->id), 'method' => 'DELETE')) !!}
				<a href="{{ route('admin.galleries.categories.index') }}" class="btn btn-default">{{ trans('admin.global.action.back') }}</a>
				{!! Form::submit(trans('admin.galleriescategory.action.delete'), ['class'=>'btn btn-danger'] ) !!}
			{!! Form::close() !!}
		</div>

	@endif


@endsection	
