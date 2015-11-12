@if (Session::has('feedback'))
	<p class="alert alert-{{ session('feedback.type', 'info') }}">{{ session('feedback.message') }}</p>
@endif
