@extends('admin')

@section('content')

	@include ('_others.feedbacks')
	
	{{-- INDEX --}}
	@if (Route::currentRouteName() == 'admin.administrators.index')

		@section('title')
			{{ trans('admin.administrators.title.index') }}
		@endsection

		@if (count($administrators)>0)
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('admin.administrators.field.name') }}</th>
						<th>{{ trans('admin.administrators.field.last_login') }}</th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($administrators as $administrator)
						<tr>
							<td>{{ $administrator->name }}</td>
							<td>{{ $administrator->last_login->diffForHumans() }}</td>
							<td class="actions">
								<a href="{{ route('admin.administrators.edit', [$administrator->id]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
								<a href="{{ route('admin.administrators.delete', [$administrator->id]) }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		@else
			<div class="alert alert-danger" role="alert">
				{{trans('admin.administrators.message.nocontent') }}
			</div>
		@endif
		<a href="{{ route('admin.administrators.create') }}" class="btn btn-success">{{ trans('admin.administrators.action.add') }}</a>

	@endif

	{{-- CREATE --}}
	@if (Route::currentRouteName() == 'admin.administrators.create')

		@section('title')
			{{ trans('admin.administrators.title.create') }}
		@endsection

		{!! form($form) !!}

	@endif

	{{-- EDIT --}}
	@if (Route::currentRouteName() == 'admin.administrators.edit')

		@section('title')
			{{ trans('admin.administrators.title.edit') }} <small>- {{ $administrator->name }}</small>
		@endsection
		
		{!! form($form) !!}

	@endif

	{{-- DELETE --}}
	@if (Route::currentRouteName() == 'admin.administrators.delete')

		@section('title')
			{{ trans('admin.administrators.title.delete') }}
		@endsection

		<p class="text text-danger">
			{{ trans('admin.administrators.message.delete') }}
		</p>

		{!! Form::model($administrator, array('route' => array('admin.administrators.destroy', $administrator->id), 'method' => 'DELETE')) !!}
			<a href="{{ route('admin.administrators.index') }}" class="btn btn-default">Retour</a>
			{!! Form::submit(trans('admin.administrators.action.delete'), ['class'=>'btn btn-danger'] ) !!}
		{!! Form::close() !!}

	@endif


@endsection


@section('javascript')
	
	@parent

	<script type="text/javascript">
		tinymce.init({
			language: 'fr_FR',
            selector: "textarea.wysiwyg",
            menubar: false,
            content_css : "{{ asset('css/wysiwyg.css') }}",
           	style_formats : [
           		{title : "Headings", items: [
	           		{ title: "Heading 1", block : 'h1'},
	           		{ title: "Heading 2", block : 'h2'},
	           		{ title: "Heading 2", block : 'h3'},
	           	]},
	           	{title : "Blocks", items: [
	           		{ title: "Paragraph", block : 'p'},
	           		{ title: "Blockquote", block : 'blockquote'},
	           	]}
            ],
            formats: {
				alignleft: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_left', styles: {textAlign: 'left'}, defaultBlock: 'div'},
					{selector: 'img,table', collapsed: false, classes: 'align_left', styles: {'float': 'left'}}
				],
				aligncenter: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_center', styles: {textAlign: 'center'}, defaultBlock: 'div'},
					{selector: 'img', collapsed: false, classes: 'align_center', styles: {display: 'block', marginLeft: 'auto', marginRight: 'auto'}},
					{selector: 'table', collapsed: false, classes: 'align_center', styles: {marginLeft: 'auto', marginRight: 'auto'}}
				],
				alignright: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_right', styles: {textAlign: 'right'}, defaultBlock: 'div'},
					{selector: 'img,table', collapsed: false, classes: 'align_right', styles: {'float': 'right'}}
				],
				alignjustify: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_justify', styles: {textAlign: 'justify'}, defaultBlock: 'div'},
					{selector: 'img', collapsed: false, classes: 'align_justify', styles: {display: 'block'}}
				]
			},
            toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image"
        });
	</script>

@endsection
