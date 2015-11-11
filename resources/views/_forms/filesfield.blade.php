
<div class="form-group clearfix">

	
	<label for="">{{ trans('admin.pages.field.'.$name) }}</label>
	<input class="form-control" name="{{ $name }}_new" id="{{ $name }}_new" value="{{ Request::old($name.'_new') }}" type="hidden" />

	<div id="{{ $name }}" class="panel panel-default clearfix filebrowser dropzone">
  		<div class="panel-body">
  			<ul id="{{ $name }}-files-container" class="files clearfix">
				@if (isset($options['value']))
					@forelse($options['value'] as $file)
						@include('_forms.itemfilebrowser', ['file' => $file])
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
    	$( "#{{ $name }}-files-container" ).sortable({
      		placeholder: "ui-state-highlight dz-details file col-lg-4 col-md-6 ",
      		start: function(event, ui){
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
	  				},
	  				success: function(response) {
	  					console.log(response);
	  				}
	  			});
    		}

    	});

		/* Modal edit/delete/show */
		$('#{{ $name }}-files-container').on("click", '.modal-edit-open', function(event) {
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-edit'),
				'title' : "{{ trans('admin.files.title.edit') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.update.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.update.error') }}",
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-delete-open', function(event) {
			var button = $(this);
			Admin.Modal.ajaxForm({
				'url' : $(this).attr('data-url-delete'),
				'title' : "{{ trans('admin.files.title.delete') }}",
				'messageSuccess': "{{ trans('admin.files.feedback.delete.ok') }}",
				'messageError': "{{ trans('admin.files.feedback.delete.error') }}",
				'callbackSuccess': function() {
					button.parents('li').remove();
					if ($('#{{ $name }}-files-container .dz-details').length <= 0) {
						$('#{{ $name }} .dz-message').show();
					}
				}
			});
		});
		$('#{{ $name }}-files-container').on("click", '.modal-show-open', function(event) {
			Admin.Modal.picture($(this).attr('data-url-show'));
		});

		/* Dropzone */
		Dropzone.autoDiscover = false;
		var myDropzone{{ $name }} = new Dropzone({{ $name }}, {
			dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
         	dictFileTooBig: "File is too big ",
       		dictInvalidFileType: "You can't upload files of this type.",
         	dictResponseError: "Server responded with code.",
         	dictCancelUpload: "Cancel upload",
			dictDefaultMessage: "",
	  		//paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 5, // MB
	  		autoProcessQueue: false,
	  		url: "{{ route('admin.files.store') }}",
	  		parallelUploads: 1,
 	  		acceptedFiles: "{{ $options['dropzone_acceptedFiles'] }}",
	  		previewsContainer: '#{{ $name }}-files-container',
	  		previewTemplate: '<div style="display:none"></div>',
	  		uploadMultiple: false,
		  	init: function() {
		  		var dropzone = this;
		  		var modalFilesUpload = null;
		  		var modalIsOpen = false;
		  		var modalFilesUpload = null;
		
		  		this.on("addedfiles", function(files) {

		  			console.log(files);
		  		
					modalFilesUpload = Admin.Modal.filesUpload();
					modalFilesUpload.find('button#button-cancel-upload').bind('click', function() {
						refreshDropzone('{{ $name }}');
					});
					modalFilesUpload.find('button#button-start-upload').bind('click', function() {
						// Upload first file
						myDropzone{{ $name }}.processQueue();
					});
						
					var modalBodyTable = modalFilesUpload.find('.modal-body table tbody');
					modalBodyTable.html('');
					for (var i = 0; i < files.length; i++) {
						files[i]['id'] = (i+1);
						modalBodyTable.append(
							'<tr id="upload-file-'+files[i]['id']+'"><th scope="row">'+(i+1)+'</th><td class="upload-name"><span class="overflow">'+files[i]['name']+'</span></td><td class="upload-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div></div></td><td class="text-center upload-status"><span class="label label-info">{{ trans("admin.files.label.status.pending") }}</span></td></tr>'
						);
					};
				
  				});
			  	this.on("sending", function(file, xhr, formData) {
			  		console.log('sending '+file.name);
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_field", "{{ $options['model_field'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			  	this.on("uploadprogress", function(file, progress)  {
			  		console.log('uploadprogress');
			  		var progressionBar = $('#upload-file-'+file['id']+' .progress-bar');
			  		progressionBar.width(progress+'%').text(progress+'%');
			  		if (progress=='100') {
			  			progressionBar.addClass('progress-bar-success');
			  		}
			  	});
			  	
			  	this.on("queuecomplete", function() {
			  		console.log('queuecomplete event');
					modalIsOpen = false;
		  			modalFilesUpload.find('button#button-start-upload').hide();
		  			refreshDropzone('{{ $name }}');	
			  	});
			  	this.on("complete", function(file)  {
			  		console.log('complete');
			  		var lineUpload = $('#upload-file-'+file['id']);
			  		console.log(file['id']);
			  		console.log('sttus '+file.status);
			  		var labelStatus = lineUpload.find('.upload-status .label').removeClass('label-info');
			  		if (file.status == 'success') {
			  			console.log('TODO success');
						labelStatus.addClass('label-success').html("{{ trans('admin.files.label.status.success') }}");
			  		} else if (file.status == 'error') {
			  			console.log('TODO ERROR');
			  			lineUpload.addClass('bg-danger');
			  			labelStatus.addClass('label-danger').html("{{ trans('admin.files.label.status.unaccepted') }}");
			  		}
			  	});
			  	this.on("success", function(file, response)  {
			  		console.log('success');
			  		// Add File in file browser
			  		var fileId = response['file']['id'];
			  		$.ajax({
		  				url: "{{ route('admin.files.getitemfilebrowser') }}",
		  				method: 'POST',
		  				data: {
		  					'_token' : "{{ csrf_token() }}",
		  					'file_id' : fileId
		  				},
		  				success: function(response) {
		  					$(dropzone.options.previewsContainer).append(response);
		  				}
		  			});
			  		// Upload next file
			  		myDropzone{{ $name }}.processQueue();
			  		refreshDropzone('{{ $name }}');
			  	});
			}
		});
		function refreshDropzone(fieldName) {
			if ($('#'+fieldName+'-files-container .dz-details').length = 0) {
				$('#{{ $name }} .dz-message').show();
			} else {
				$('#{{ $name }} .dz-message').hide();
			}
		}
		
	</script>

@stop
