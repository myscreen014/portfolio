<li id="preview-file-{{ $file->id }}" data-file-id="{{ $file->id }}" class="dz-details file col-md-6 col-lg-4">
	<div class="dz-details-inner clearfix">
		<span class="file-thumnails">
			@if($file->isPicture())
				<img src="{{ route('picture', ['filebrowser', $file->name]) }}" />
			@else
				<span class="img-type"><i class="fa {{ $file->getIconClass() }}"></i></span>
			@endif
		</span>
		<span class="file-infos">
			<strong class="file-name overflow">
				@if (isset($file->title) && !empty($file->title))
					{{ $file->title }}
				@else
					{{ $file->name }}
				@endif 
			</strong>
			<small class="file-type overflow">{{ $file->type }}</small>
			<p class="file-legend text-muted"><small>{{ str_limit($file->legend, 80) }}</small></p>
		</span>
		<span class="file-actions">
			<span class="btn-group">
				<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', $file->id) }}"><i class="fa fa-pencil"></i></button>
				<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', $file->id) }}"><i class="fa fa-trash-o"></i></button>
				@if($file->isPicture())
					<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', $file->id) }}"><i class="fa fa-eye"></i></button>
				@else
					<a href="{{ route('file', $file->name) }}" class="btn btn-default btn-xs" target="_blank"><i class="fa fa-download"></i></a>
				@endif
			</span>
		</span>
	</div>
</li>