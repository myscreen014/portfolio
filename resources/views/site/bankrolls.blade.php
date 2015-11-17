@extends('site')


@section('content')

	<table class="table">
		<thead></thead>
		<tbody>
			@foreach($bankrolls->sessions as $session)
				<tr>
					<td>{{ $session->amount }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

