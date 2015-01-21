@extends('app')

@section('content')

<?php if (!isset($list_type)) { $list_type = ''; } ?>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						{!! link_to_route('words_path', 'Words') !!} / List {{ $list_type != '' ? '/ '.$list_type : '' }}
					</h2>
				</div>

				<div class="panel-body">

					@if ($list_type == 'Random word')
						<button onclick="document.location='{{ route('word_random_path') }}'" type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-question-sign"></span> Random word
						</button><br><br>
					@endif

					<div class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="active">
										<th>Row</th>
										<th>Type</th>
										<th><img src="/img/flags/DK.png"></th>
										<th><img src="/img/flags/EN.png"></th>
										<th><img src="/img/flags/FR.png"></th>
										<th><img src="/img/flags/PL.png"></th>
										<th><img src="/img/flags/ES.png"></th>
										<th>Time DK</th>
										<th>Time PL</th>
										<th>Time ES</th>
									</tr>
								</thead>
								@forelse ($words as $word)
									<tr class="clickable">
										<td onclick="document.location = '/words/{{ $word->id }}/edit'">{{ $word->id }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=type'">{{ $word->type }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=DK'">{{ $word->DK }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=EN'">{{ $word->EN }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=FR'">{{ $word->FR }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=PL'">{{ $word->PL }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=ES'">{{ $word->ES }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=TSDK'">{{ $word->TSDK }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=TSPL'">{{ $word->TSPL }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=TSES'">{{ $word->TSES }}</td>
									</tr>
								@empty
									<tr><td colspan="10">There seems to be nothing here.</td></tr>
								@endforelse
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
