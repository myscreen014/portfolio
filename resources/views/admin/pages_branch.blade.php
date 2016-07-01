@foreach($pages as $page)

	<tr data-item-id="{{ $page['id'] }}" class="publish-{{ $page['publish'] }}">
		
			<td class="publish" >
				<a href="#" data-toggle="tooltip" title="@if ($page['publish']) {{ trans('admin.global.label.publish') }} @else {{ trans('admin.global.label.draft') }} @endif"><i class="fa fa-square"></i></a>
			</td>
			<td>
				{{ $page['name']}}
				<table class="table sortable"  data-model="page">
					@include('admin.pages_branch', array(
						'pages' => $page['children'], 
						'level' => $level+1
					))
				</table>
			</td>
	</tr>

@endforeach


{{--
@foreach($pages as $page)
	<tr data-item-id="{{ $page['id'] }}" class="publish-{{ $page['publish'] }}">
		<td class="publish" >
			<a href="#" data-toggle="tooltip" title="@if ($page['publish']) {{ trans('admin.global.label.publish') }} @else {{ trans('admin.global.label.draft') }} @endif"><i class="fa fa-square"></i></a>
		</td>
		<td>
			<i class="fa page-controller {{ Config::get('administration.components.'.$page['controller'].'.icon') }}"></i>
	
			@for($i=1;$i<$level;$i++)
				<i class="fa"></i>
			@endfor
			@if (isset($page['children']) and count($page['children'])>0)
				<i class="fa fa-caret-down"></i>	
			@else 
				<i class="fa fa-caret-right"></i>		
			@endif
			{{ $page['name'] }} 
		</td>
		<td class="actions">
			<a href="{{ route('admin.pages.edit', [$page['id']]) }}" class="btn btn-primary btn-xs">{{ trans('admin.global.action.edit') }}</a>
			<a href="{{ route('admin.pages.delete', [$page['id']]) }}" class="btn btn-danger btn-xs">{{ trans('admin.global.action.delete') }}</a>
		</td>
	</tr>
	@if (isset($page['children']) and count($page['children'])>0)
		@include('admin.pages_branch', array(
			'pages' => $page['children'], 
			'level' => $level+1
		))
	@endif
@endforeach
--}}