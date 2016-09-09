 $.extend(Admin, {

	Upload: {

		init: function(config) {

			var _config = {
				acceptedFiles : "",
			};
			$.extend(_config, config);
 
			/* Dropzone */  
			Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone('#'+_config.field, {
				dictDefaultMessage: "",
		  		//paramName: "file", // The name that will be used to transfer the file
		  		maxFilesize: 24, // MB
		  		maxFiles: 10,
		  		clickable: _config.clickable,
		  		autoProcessQueue: false,
		  		url: _config.routeStore,
		  		parallelUploads: 1,
	 	  		acceptedFiles: _config.acceptedFiles,
		  		previewsContainer: null,
		  		previewTemplate: '<div style="display:none"></div>',

		  		dictResponseError: Admin._i18n['file']['label']['status']['error'],
		  		dictInvalidFileType: Admin._i18n['file']['label']['status']['unaccepted'],
		  		
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
			  	
			  			// Create modal
						modalFilesUpload = Admin.Modal.filesUpload();
						
						var modalBodyTable = modalFilesUpload.find('.modal-body table tbody');

						actionUpload = modalFilesUpload.find('.modal-footer #action-upload-start').bind('click', function() {
							modalFilesUpload.find('#action-upload-cancel').prop("disabled", true);
							dropzone.processQueue();
						});
						actionCancel = modalFilesUpload.find('.modal-footer #action-upload-cancel').bind('click', function() {
							dropzone.removeAllFiles();
						});

						for (var i = 0; i < files.length; i++) {
							files[i]['id'] = (i+1);
							if (i > dropzone.options.maxFiles-1) { break; }
							modalBodyTable.append(
								'<tr id="upload-file-'+files[i]['id']+'"><th scope="row">'+(i+1)+'</th><td class="upload-name"><span class="overflow">'+files[i]['name']+'</span></td><td class="upload-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div></div></td><td class="text-center upload-status"><span class="label label-info">'+Admin._i18n['file']['label']['status']['pending']+'</span></td></tr>'
							);
						};
	  				});
					this.on("complete", function(file) {
  						this.removeFile(file);
  						dropzone.processQueue();
					});

					this.on("sending", function(file, xhr, formData) {
				   		formData.append("_token", _config.token);
				   		formData.append("model_table", _config.modelTable);
				   		formData.append("model_field",  _config.modelField);
				   		formData.append("model_id",  _config.modelId);
				  	});
				
				  	this.on("uploadprogress", function(file, progress)  {
				  		var progressionBar = $('#upload-file-'+file['id']+' .progress-bar');
				  		progressionBar.width(progress+'%').text(Math.ceil(progress)+'%');
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
				  		labelStatus.addClass('label-success').html(Admin._i18n['file']['label']['status']['success']);

				  		if (typeof _config.success == 'function') {
				  			_config.success(response['file']);	
				  		}
			
				  	});
				  	this.on("queuecomplete", function() {
				  		if (dropzone.getQueuedFiles().length==0) {
				  			dropzone.removeAllFiles();
				  			actionUpload.remove();
							modalFilesUpload.find('button').prop("disabled", false);
				  		}
				  	});
				}
			});
		
		}
	}

});