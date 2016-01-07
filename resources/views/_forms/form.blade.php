
<div class="form-wrapper" >

	@if (count($errors) > 0)
        <ul class="errors alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
	@endif

	{!! form($form) !!}

</div>

@section('javascript')
	
	@parent

	<script type="text/javascript">
	
		/* FORM */
		$(document).ready(function() {
			$('.form-wrapper').fadeIn('fast');
		});

	</script>

@endsection