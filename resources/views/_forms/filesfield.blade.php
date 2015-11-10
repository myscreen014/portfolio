
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
		  		var cmptFileToUpload = 1;
		  		this.on("addedfile", function(file) {

	  				file['id'] = cmptFileToUpload++;
					if (!modalIsOpen) {
						modalFilesUpload = Admin.Modal.filesUpload();
						modalFilesUpload.find('button#button-cancel-upload').bind('click', function() 
							refreshDropzone('{{ $name }}');
						});
						modalFilesUpload.find('button#button-start-upload').bind('click', function() {
							// Upload first file
							myDropzone{{ $name }}.processQueue();
						});
						modalIsOpen = true;
					} else {
						console.log("non");
					}
					modalFilesUpload.find('.modal-body').append(
						'<label>'+file.name+'</label><div class="progress"><div id="file-progression-'+file['id']+'" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100">0%</div></div>'
					);
					
  				});
			  	this.on("sending", function(file, xhr, formData) {
			  		console.log('sending');
			   		formData.append("_token", "{{ csrf_token() }}");
			   		formData.append("model_table", "{{ $options['model_table'] }}");
			   		formData.append("model_field", "{{ $options['model_field'] }}");
			   		formData.append("model_id", "{{ $options['model_id'] }}");
			  	});
			  	this.on("uploadprogress", function(file, progress)  {
			  		console.log('uploadprogress');
			  		var progressionBar = $('#file-progression-'+file['id']);
			  		progressionBar.width(progress+'%').text(progress+'%');
			  		if (progress=='100') {
			  			progressionBar.addClass('progress-bar-success');
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
			  	this.on("queuecomplete", function() {
			  		console.log(this.getAcceptedFiles());
			  		
						modalIsOpen = false;
			  			modalFilesUpload.find('button#button-start-upload').hide();
			  			refreshDropzone('{{ $name }}');	
			  		
			  	});
			  	this.on("error", function(file, response)  {
			  		console.log('error');
					Admin.Modal.alert("{{ trans('admin.files.title.upload')}}", "{{ trans('admin.files.message.upload.error.acceptedfiles')}}");
					
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
