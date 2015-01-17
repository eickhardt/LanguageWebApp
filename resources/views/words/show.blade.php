@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						{!! link_to_route('words_path', 'Words') !!} / <b>{{ $word->FR }}</b> (FR)
					</h2>
				</div>

				<div class="panel-body">
					<div class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered">
								<thead>
									<tr class="active">
										<th>Row</th>
										<th>Type</th>
										<th>French</th>
										<th>English</th>
										<th>Polish</th>
										<th>Spanish</th>
										<th>Danish</th>
										<th>Time PL</th>
										<th>Time DK</th>
										<th>Time ES</th>
									</tr>
								</thead>
								<tr>
									<td>{{ $word->id }}</td>
									<td>{{ $word->type }}</td>
									<td>{{ $word->FR }}</td>
									<td>{{ $word->EN }}</td>
									<td>{{ $word->PL }}</td>
									<td>{{ $word->ES }}</td>
									<td>{{ $word->DK }}</td>
									<td>{{ $word->TSPL }}</td>
									<td>{{ $word->TSDK }}</td>
									<td>{{ $word->TSES }}</td>
								</tr>
							</table>
						</div>
					</div>
					<button onclick="document.location='{{ route('word_edit_path', $word->id) }}'" type="submit" class="btn btn-primary">
						~ Edit
					</button>
					{!! Form::open(['url' => route('word_delete_path', $word->id), 'method' => 'DELETE', 'class' => 'inline']) !!}
						<button type="submit" class="btn btn-primary">
							- Delete
						</button>
					{!! Form::close() !!}
					<?php /*<a href="/words/{{ $word->id }}/edit">Edit</a> / <a href="/words/{{ $word->id }}/delete">Delete</a> </b>*/ ?>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
