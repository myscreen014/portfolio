<li id="preview-file-{{ $file->id }}" data-file-id="{{ $file->id }}" class="dz-details file col-md-6 col-lg-4">
	<div class="dz-details-inner clearfix">
		<span class="file-thumnails">
			@if($file->isPicture())
				<img src="{{ route('file', $file->id.'.filebrowser')}}" />
			@else
				<span class="img-type"><i class="fa {{ $file->getIconClass() }}"></i></span>
			@endif
		</span>
		<span class="file-infos">
			<strong class="file-name overflow">{{ $file->name }}</strong>
			<small class="file-type overflow">{{ $file->type }}</small>
			<p class="file-legend text-muted"><small>{{ str_limit($file->legend, 100) }}</small></p>
		</span>
		<span class="file-actions">
			<span class="btn-group">
				<button type="button" class="btn btn-primary btn-xs modal-edit-open" data-url-edit="{{ route('admin.files.edit', $file->id) }}"><i class="fa fa-pencil"></i></button>
				<button type="button" class="btn btn-danger btn-xs modal-delete-open" data-url-delete="{{ route('admin.files.delete', $file->id) }}"><i class="fa fa-trash-o"></i></button>
				<button type="button" class="btn btn-default btn-xs modal-show-open" data-url-show="{{ route('admin.files.show', $file->id) }}"><i class="fa fa-eye"></i></button>
			</span>
		</span>
	</div>
</li>