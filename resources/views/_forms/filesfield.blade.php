<div class="form-group">
	<label for="">Fichiers</label>
	<div class="dropzone" style="height: 100px; outline: 1px solid red;" id="myAwesomeDropzone"></div>
</div>

<script src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">	
	
	
		Dropzone.options.myAwesomeDropzone = {
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 2, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		accept: function(file, done) {
		    	if (file.name == "justinbieber.jpg") {
		      		done("Naha, you don't.");
		    	} else { done(); }
		  	}
		};
	
	
</script>