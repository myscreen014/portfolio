
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
			$('form .counter-chars').each(function() {
				var field = $(this);
				field.parent().prepend('<span class="label label-info counter-chars">0</span>');
				field.bind('change keyup', function() {
					field.parent().find('.label.counter-chars').html(field.val().length);
				}).trigger('change');
			});	
			$('.form-wrapper').fadeIn('fast');
		});

	</script>

@endsection