<div class="form-group">
	<label for="">Fichiers</label>
	<div class="dropzone" id="myAwesomeDropzone"></div>
</div>

<script src="{{ asset('js/dropzone.js') }}"></script>

@section('javascript')

	<script type="text/javascript">	
		Dropzone.options.myAwesomeDropzone = {
	  		paramName: "file", // The name that will be used to transfer the file
	  		maxFilesize: 2, // MB
	  		url: "{{ route('admin.files.store') }}",
	  		uploadMultiple: false,
	  		addRemoveLinks: false,
	  		clickable: true,
	  		accept: function(file, done) {
		    	done();
		  	},
		  	init: function() {
			  	this.on("sending", function(file, xhr, formData) {
			   		formData.append("_token", "{{ csrf_token() }}"); // Append all the additional input data of your form here!
			  	});
			}
		};
	</script>

@stop
