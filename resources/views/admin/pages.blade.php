@extends('admin')

@section('content')

	@include('_others.feedbacks')

	
	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.pages.index')

		@section('title')
			{{ trans('admin.page.title.index') }}
		@endsection

		@foreach(array('primary','secondary') as $menu)
			@if (count($pages[$menu])>0)
				<table class="table table-hover table-pages sortable publishable" data-model="page">
					<thead>
						<tr>
							<th colspan="3">{{ trans('admin.page.option.menu.'.$menu) }}</th>
							<th class="actions"></th>
						</tr>
					</thead>
					<tbody>
						@include('admin.pages_branch', array(
							'pages' => $pages[$menu], 
							'level' => 1
						))
					</tbody>
				</table>
			@endif
		@endforeach
			
		@if (count($pages['primary'])==0 && count($pages['secondary'])==0)
			<div class="alert alert-danger" role="alert">
				{{ trans('admin.page.message.nocontent') }}
			</div>
		@endif

		<div class="actions">			
			<a href="{{ route('admin.pages.create') }}" class="btn btn-success">{{ trans('admin.page.action.add') }}</a>
		</div>

	@endif

	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.pages.create')

		@section('title')
			{{ trans('admin.page.title.create') }}
		@endsection

		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.pages.edit')

		@section('title')
			{{ trans('admin.page.title.edit') }} <small> - {{ $page->name }}</small>
		@endsection
		
		@include('_forms.form', array(
			'form' => $form
		))

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.pages.delete')

		@section('title')
			{{ trans('admin.page.title.delete') }} <small> - {{ $page->name }}</small>
		@endsection

		<p class="text text-danger">
			{{ trans('admin.page.message.delete') }}
		</p>
		<div class="actions">
			{!! Form::model($page, array('route' => array('admin.pages.destroy', $page->id), 'method' => 'DELETE')) !!}
				<a href="{{ route('admin.pages.index') }}" class="btn btn-default">{{ trans('admin.global.action.back') }}</a>
				{!! Form::submit(trans('admin.page.action.delete'), ['class'=>'btn btn-danger'] ) !!}
			{!! Form::close() !!}
		</div>

	@endif


@endsection

@section('javascript')

	@parent

	@if (in_array(Route::currentRouteName(), array('admin.pages.create', 'admin.pages.edit')))
		<script type="text/javascript">
			$('select#controller').bind('change', function() {
				if ($(this).val() != 'pages') {
					$('.form-field:not(.form-field-actions)').hide();
					$('.form-field-name, .form-field-menu, .form-field-parent, .form-field-controller, .form-field-pictures, .form-field-group-metadatas, .form-field-meta-title, .form-field-meta-description').show();
				} else {
					$('.form-field').show();
				} 
			}).trigger('change');
		</script>
	@endif

@endsection



