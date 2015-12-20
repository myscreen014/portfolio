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
				<table class="table table-pages table-hover sortable" data-model="page">
					<thead>
						<tr>
							<th>{{ trans('admin.page.option.menu.'.$menu) }}</th>
							<th class="actions"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($pages[$menu] as $page)
							<tr data-item-id="{{ $page->id }}">
								<td><i class="fa {{ Config::get('administration.components.'.$page->controller.'.icon') }}"></i>{{ $page->name }}</td>
								<td class="actions">
									<a href="{{ route('admin.pages.edit', [$page->id]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
									<a href="{{ route('admin.pages.delete', [$page->id]) }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
								</td>
							</tr>
						@endforeach	
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

	<script type="text/javascript">
		$('select#controller').bind('change', function() {
			if ($(this).val() != 'pages') {
				$('.form-field:not(.form-field-actions)').hide();
				$('.form-field-name, .form-field-menu, .form-field-controller, .form-field-pictures, .form-field-group-metadatas, .form-field-meta-title, .form-field-meta-description').show();
			} else {
				$('.form-field').show();
			} 
		}).trigger('change');
	</script>

@endsection



