@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				@if (isset($list_type) && $list_type == 'Random')
					<span class="glyphicon glyphicon-question-sign"></span>
				@elseif (isset($list_type) && $list_type == 'Word of the Day')
					<span class="glyphicon glyphicon-certificate"></span>
				@elseif (isset($list_type) && $list_type == 'Trashed')
					<span class="glyphicon glyphicon-trash"></span>
				@else
					<span class="glyphicon glyphicon-list-alt"></span>
				@endif
				Meanings / List / <b>{{ isset($list_type) ? $list_type : ucfirst($meanings[0]->english) }}</b>
			</h2>
		</div>
		<div class="panel-body">

			@forelse ($meanings as $meaning)
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>Meaning information</h4>
						<div class="row">
							<div class="col-md-6 col-md-offset-0">
								<ul class="list-group">
									<li class="list-group-item">
										English: <b>{{ ucfirst($meaning->english) }}</b>
									</li>
									<li class="list-group-item">
										Type name: <b>{{ ucfirst($meaning->type->name) }}</b>
									</li>
									<li class="list-group-item">
										Real type: <b>{{ $meaning->real_word_type }}</b>
									</li>
								</ul>
							</div>
							<div class="col-md-6 col-md-offset-0">
								<ul class="list-group">
									<li class="list-group-item">
										Id: <b>{{ $meaning->id }}</b>
									</li>
									<li class="list-group-item">
										Created at {{ date("F j, Y, g:i a", strtotime($meaning->created_at)) }}
									</li>
									<li class="list-group-item">
										Last updated at {{ date("F j, Y, g:i a", strtotime($meaning->updated_at)) }}
									</li>
								</ul>
							</div>
						</div>

						@if (isset($list_type) && $list_type == 'Trashed')
							<button onclick="document.location='{{ route('meaning_restore_path', $meaning->id) }}'" type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon glyphicon-refresh"></span> Restore meaning
							</button>
						@else
							<button onclick="document.location='{{ route('meaning_edit_path', $meaning->id) }}'" type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon glyphicon-pencil"></span> Edit
							</button>
						@endif
						<br><br>

						@if (isset($list_type) && $list_type == 'Trashed')
							<?php /* We don't want any words to show up if it's the trashed list */ ?>
						@else
							<h4>Words belonging to this meaning</h4>
							<ul class="list-group">
								@foreach ($languages as $language)
									<li class="list-group-item">
										<img class="meaning_words_flag" src="{{ $language->image }}">

										<?php $count = 0; ?>

										@foreach ($meaning->words as $word)
											@if ($word->word_language_id == $language->id)
												{!! link_to_route('word_path', $word->text, $word->id) !!}
												<?php $count++; ?>
											@endif
										@endforeach

										<span class="badge">{{ $count }}</span>
									</li>
								@endforeach
							</ul>	

							<button onclick="document.location='{{ route('word_create_path') }}?meaning_id={{ $meaning->id }}'" type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-plus-sign"></span> Add word
							</button><br>
						@endif

					</div>
				</div>
			@empty
				<ul class="list-group">
					<li class="list-group-item">There seems to be nothing here.</li>
				</ul>
			@endforelse

			
			@if (isset($list_type) && $list_type == 'Random')
				<button onclick="document.location='{{ route('meaning_random_path') }}'" type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-question-sign"></span> Another one
				</button>
			@endif

			<button onclick="document.location='{{ route('search_path') }}'" type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span> Goto search
			</button>
		</div>
	</div>
@endsection
