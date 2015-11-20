@extends('admin')

@section('content')

	@include('_others.feedbacks')

	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.'.$componentName.'.index')
	
		@section('title')
			{{ trans('admin.'.$modelName.'.title.index') }}
		@endsection

		@if (count($items)>0)
			<table class="table table-hover sortable" data-model="{{ $modelName }}">
				<thead>
					<tr>
						@foreach($listFields as $field)
							<th>{{ trans('admin.'.$modelName.'.field.'.$field) }}</th>
						@endforeach
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($items as $item)
						<tr data-item-id="{{ $item->id }}">
							@foreach($listFields as $field)
								<td>{{ $item->$field }}</td>
							@endforeach 
							<td class="actions">
								<?php $routeEdit = route('admin.'.$componentName.'.edit', [$item->id]) ?>	
								<?php $routeDelete = route('admin.'.$componentName.'.delete', [$item->id]) ?>	
								<a href="{{ $routeEdit }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="{{ $routeDelete }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		@else
			<div class="alert alert-danger" role="alert">
				{{ trans('admin.'.$modelName.'.message.nocontent') }}
			</div>
		@endif

		<div class="actions">		
			<?php $routeEdit = route('admin.'.$componentName.'.create') ?>		
			<a href="{{ $routeEdit }}" class="btn btn-success">{{ trans('admin.'.$modelName.'.action.add') }}</a>
		</div>
		
	@endif 


	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.'.$componentName.'.create')

		@section('title')
			{{ trans('admin.'.$modelName.'.title.create') }}
		@endsection

		@include('_forms.form', array(
			'form' => $form
		))

	@endif


	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.'.$componentName.'.edit')

		@section('title')
			{{ trans('admin.'.$modelName.'.title.edit') }} <small> - {{ $model->name }}</small>
		@endsection
		
		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.'.$componentName.'.delete')

		@section('title')
			{{ trans('admin.'.$modelName.'.title.delete') }} <small> - {{ $model->name }}</small>
		@endsection

		<p class="text text-danger">
			{{ trans('admin.page.message.delete') }}
		</p>
		<div class="actions">
			<?php $routeBack = route('admin.'.$componentName.'.index'); ?>	
			{!! Form::model($model, array('route' => array('admin.'.$componentName.'.destroy', $model->id), 'method' => 'DELETE')) !!}
				<a href="{{ $routeBack }}" class="btn btn-default">{{ trans('admin.global.action.back') }}</a>
				{!! Form::submit(trans('admin.page.action.delete'), ['class'=>'btn btn-danger'] ) !!}
			{!! Form::close() !!}
		</div>

	@endif


@endsection