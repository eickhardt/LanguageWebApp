@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				@if (isset($list_type) && $list_type == 'Random')
					<span class="glyphicon glyphicon-question-sign"></span>
				@elseif (isset($list_type) && $list_type == 'Trashed')
					<span class="glyphicon glyphicon-trash"></span>
				@else
					<span class="glyphicon glyphicon-list-alt"></span>
				@endif
				Words / List / <b>{{ isset($list_type) ? $list_type : ucfirst($words[0]->text) }}</b>
			</h2>
		</div>
		<div class="panel-body">
			@forelse ($words as $word)
				<div class="panel panel-default">
					<div class="panel-body">

						<h4>Information about the word</h4>
						<div class="row">
							<div class="col-md-6 col-md-offset-0">
								<ul class="list-group">
									<li class="list-group-item">
										Text: <b>{{ $word->text }}</b>
									</li>
									<li class="list-group-item">
										Language: <img src="{{ $word->language->image }}"> {{ $word->language->name }}
									</li>
								</ul>
							</div>
						
							<div class="col-md-6 col-md-offset-0">
								<ul class="list-group">
									<li class="list-group-item">
										Created at {{ date("F j, Y, g:i a", strtotime($word->created_at)) }}
									</li>
									<li class="list-group-item">
										Last updated at {{ date("F j, Y, g:i a", strtotime($word->updated_at)) }}
									</li>
								</ul>
							</div>
						</div>

						@if ($word->deleted_at)
							<button onclick="document.location='{{ route('word_restore_path', $word->id) }}'" type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-refresh"></span> Restore word
							</button>
						@else
							<button onclick="document.location='{{ route('word_edit_path', $word->id) }}'" type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon glyphicon-pencil"></span> Edit word
							</button>
						@endif

						<br><br>

						@forelse ($word->meanings as $meaning)
							<h4>Related meanings</h4>
							<ul class="list-group">
								<li class="list-group-item">{!! link_to_route('meaning_path', ucfirst($meaning->english), $meaning->id) !!}</li>
							</ul>
						@empty
							<ul class="list-group">
								<li class="list-group-item">There seems to no related meanings.</li>
							</ul>
						@endforelse
					</div>
				</div>

			@empty
				<ul class="list-group">
					<li class="list-group-item">There seems to be nothing here.</li>
				</ul>
			@endforelse
			
			@if (isset($list_type) && $list_type == 'Random')
				<button onclick="document.location='{{ route('word_random_path') }}'" type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-question-sign"></span> Another one
				</button>
			@endif

			<button onclick="document.location='{{ route('search_path') }}'" type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span> Goto search
			</button>
		</div>
	</div>
@endsection
