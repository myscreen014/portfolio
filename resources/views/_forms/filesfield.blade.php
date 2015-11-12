
<div class="form-group clearfix">

	<label for="">{{ trans('admin.pages.field.'.$name) }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
		<div class="panel-heading text-right">
			<span class="label label-info">{!! trans('admin.files.label.count.short', array('count' => count($options['value']))) !!}</span>
		</div>
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
				@if (isset($options['value']))
					@forelse($options['value'] as $file)
						@include('_forms.itemfilesfield', ['file' => $file])
					@empty
						<p class="dz-message">{{ trans('admin.global.message.upload_file_here') }}</p>
					@endforelse
				@endif
			</ul>
  		</div>
	</div>
</div>

@section('javascript')

	@parent

	<script type="text/javascript">	

	
		/* Sortable - JQuery UI */
		var heightInitContainer = null;
    	var containerSortable = $( "#{{ $name }}-files-container").sortable({
      		placeholder: "ui-state-highlight dz-details file col-md-6 col-lg-4",  
      		items: "> li",   		
      		tolerance: 'pointer',
      		create: function() {
      			console.log('create');
      			heightInitContainer = $(this).height();
      			$(this).height(heightInitContainer);
      		},
      		update: function() {
      			console.log('update');
      		},
      		start: function(event, ui){
      			$(this).height(heightInitContainer);
        		ui.placeholder.innerHeight(ui.item.innerHeight());
    		},
    		stop: function(event, ui){
    			var filesIds = Array();
    			var files = $( "#{{ $name }}-files-container" ).find('li');
    			for (var i = 0; i < files.length ; i++) {
    				filesIds.push($(files[i]).attr('data-file-id'));
    			};
    			$.ajax({
	  				url: "{{ route('admin.files.reorder') }}",
	  				method: 'POST',
	  				data: {
	  					'_token' : "{{ csrf_token() }}",
	  					'filesIds': filesIds
	  				}
	  			});
    		}
    	});

		/* Modal edit/delete/show */
		$('#{{ $name }}-files-container').on("click", '.modal-edit-open', function(event) {
			var button = $(this);
			var fileId = button.parents('li').attr('data-file-id');
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-edit'),
				'title' : "{{ trans('admin.files.title.edit') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.update.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.update.error') }}",
				callbackSuccess: function() {
					refreshFile('{{ $name }}', fileId);
				}
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-delete-open', function(event) {
			var button = $(this);
			var fileId = button.parents('li').attr('data-file-id');
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-delete'),
				'title' : "{{ trans('admin.files.title.delete') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.delete.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.delete.error') }}",
				callbackSuccess: function() {
					Admin.removeFromSerializedField('{{ $name }}_new', fileId);
					button.parents('li').remove();
					refreshDropzone('{{ $name }}');
				}
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-show-open', function(event) {
			Admin.Modal.picture($(this).attr('data-url-show'));
		});

		/* Dropzone */
		Dropzone.autoDiscover = false;
		var myDropzone{{ $name }} = new Dropzone({{ $name }}, {
			dictDefaultMessage: "",
	  		//paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 5, // MB
	  		maxFiles: 5,
	  		autoProcessQueue: false,
	  		url: "{{ route('admin.files.store') }}",
	  		parallelUploads: 5,
 	  		acceptedFiles: "{{ $options['dropzone_acceptedFiles'] }}",
	  		previewsContainer: '#{{ $name }}-files-container',
	  		previewTemplate: '<div style="display:none"></div>',

	  		dictResponseError: "{{ trans('admin.files.label.status.error') }}",
	  		dictInvalidFileType: "{{ trans('admin.files.label.status.unaccepted') }}",
	  		
	  		uploadMultiple: false,
		  	init: function() {
		  		
		  		var dropzone = this;
		  		var modalFilesUpload = null;
		  		var actionUpload = null;

		  		$(document.body).bind("dragover", function(event) {
					event.preventDefault();
					return false;
	   			});
				$(document.body).bind("drop", function(event){
					event.preventDefault();	
					return false;
				});

		  		this.on("addedfiles", function(files) {
		  			
		  			// drop all files
		  			dropzone.removeAllFiles();

		  			// Create modal
					modalFilesUpload = Admin.Modal.filesUpload();
					
					var modalBodyTable = modalFilesUpload.find('.modal-body table tbody');

					actionUpload = modalFilesUpload.find('.modal-footer #action-upload-start').bind('click', function() {
						modalFilesUpload.find('#action-upload-cancel').prop("disabled", true);
						dropzone.processQueue();
					});
					
					for (var i = 0; i < files.length; i++) {
						files[i]['id'] = (i+1);
						if (i > dropzone.options.maxFiles-1) { break; }
						modalBodyTable.append(
							'<tr id="upload-file-'+files[i]['id']+'"><th scope="row">'+(i+1)+'</th><td class="upload-name"><span class="overflow">'+files[i]['name']+'</span></td><td class="upload-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div></div></td><td class="text-center upload-status"><span class="label label-info">{{ trans("admin.files.label.status.pending") }}</span></td></tr>'
						);
					};
  				});
				this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_field", "{{ $options['model_field'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			
			  	this.on("uploadprogress", function(file, progress)  {
			  		var progressionBar = $('#upload-file-'+file['id']+' .progress-bar');
			  		progressionBar.width(progress+'%').text(progress+'%');
			  		if (progress=='100') {
			  			progressionBar.addClass('progress-bar-success');
			  		}
			  	});
			  	this.on('error', function(file, errorMessage)  {
			  		var lineUpload = $('#upload-file-'+file['id']);
			  		var labelStatus = lineUpload.find('.upload-status .label').removeClass('label-info');
			  		lineUpload.addClass('bg-danger');
			  		labelStatus.addClass('label-danger').html(errorMessage);
			  	});
			  	this.on('success', function(file, response)  {
			  		var lineUpload = $('#upload-file-'+file['id']);
			  		var labelStatus = lineUpload.find('.upload-status .label').removeClass('label-info');
			  		labelStatus.addClass('label-success').html("{{ trans('admin.files.label.status.success') }}");
			  		var fileId = response['file']['id'];
			  		$.ajax({
		  				url: "{{ route('admin.files.getitemfilebrowser') }}",
		  				method: 'POST',
		  				data: {
		  					'_token' : "{{ csrf_token() }}",
		  					'file_id' : fileId
		  				},
		  				success: function(response) {
		  					Admin.addToSerializedField('{{ $name }}_new', fileId);
		  					$(dropzone.options.previewsContainer).append(response);
		  					refreshDropzone('{{ $name }}');
		  				}
		  			});
			  	});
			  	this.on("queuecomplete", function() {
			  		if (dropzone.getQueuedFiles().length==0) {
			  			actionUpload.remove();
						modalFilesUpload.find('button').prop("disabled", false);
			  		}
			  	});
			}
		});

		function refreshFile(fieldName, fileId) {
			$.ajax({
  				url: "{{ route('admin.files.getitemfilebrowser') }}",
  				method: 'POST',
  				data: {
  					'_token' : "{{ csrf_token() }}",
  					'file_id' : fileId
  				},
  				success: function(response) {
  					$('#'+fieldName+'-files-container').find('#preview-file-'+fileId).replaceWith(response);
  					refreshDropzone('{{ $name }}');
  				}
  			});
		}

		function refreshDropzone(fieldName) {
			// Refresh sortable
			containerSortable.height('auto').sortable( "refresh" );
			heightInitContainer = containerSortable.height();

			// Refresh dropzone status (empty, count files, ...)
			var countFiles = $('#'+fieldName+'-files-container .dz-details').length;
			if (countFiles == 0) {
				$('#{{ $name }} .dz-message').show();
			} else {
				$('#{{ $name }} .panel-heading .count-value').html(countFiles);
				$('#{{ $name }} .dz-message').hide();
			}
		}
		
	</script>

@stop
