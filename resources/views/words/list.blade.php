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

					<?php /* New version of dispaying words */ ?>
					@forelse ($meanings as $meaning)
						<ul class="list-group">

							@foreach ($languages as $language)
								<li class="list-group-item">
									<img src="{{ $language->image }}">

									<?php $count = 0; ?>

									@foreach ($meaning->words as $word)
										@if ($word->word_language_id == $language->id)
											{{ $word->text }}
											<?php $count++; ?>
										@endif
									@endforeach

									<span class="badge">{{ $count }}</span>
								</li>
							@endforeach

						</ul>
					@empty
						<ul class="list-group">
							<li class="list-group-item">There seems to be nothing here.</li>
						</ul>
					@endforelse
					<?php /* EO - New version of dispaying words */ ?>

					<?php /*
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
										@foreach ($languages as $language)
											<th><img src="{{ $language->image }}"></th>
										@endforeach
									</tr>
								</thead>
								@forelse ($meanings as $meaning)
									<tr class="clickable">
										<td onclick="document.location = '/words/{{ $meaning->id }}/edit'">{{ $meaning->id }}</td>
										<td onclick="document.location = '/words/{{ $meaning->id }}/edit?focus=type'">{{ $meaning->type }}</td>

										@foreach ($meaning->words as $word)
											<td title="{{ $word->created_at }}" onclick="document.location = '/words/{{ $word->id }}/edit?focus=DK'">{{ $word->text }}</td>
										@endforeach
										
										@foreach ($languages as $language)
											<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=DK'">{{ $word->DK }}</td>
										@endforeach

										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=DK'">{{ $word->DK }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=EN'">{{ $word->EN }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=FR'">{{ $word->FR }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=PL'">{{ $word->PL }}</td>
										<td onclick="document.location = '/words/{{ $word->id }}/edit?focus=ES'">{{ $word->ES }}</td>

									</tr>
								@empty
									<tr><td colspan="10">There seems to be nothing here.</td></tr>
								@endforelse
							</table>
						</div>
					</div>
					*/ ?>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
