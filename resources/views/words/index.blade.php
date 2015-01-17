@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						<a href="/words">Words</a> / Index
					</h2>
				</div>
				<div id="words" class="panel-body">
					<button onclick="document.location='{{ route('word_create_path') }}'" type="submit" class="btn btn-primary">
						+ Create new
					</button>
					<button class="sort btn btn-primary" data-sort="FR">
					    # Sort by French
					</button>
					<button class="sort btn btn-primary" data-sort="EN">
					    # Sort by English
					</button>
					<button class="sort btn btn-primary" data-sort="PL">
					    # Sort by Polish
					</button>
					<button class="sort btn btn-primary" data-sort="ES">
					    # Sort by Spanish
					</button>
					<button class="sort btn btn-primary" data-sort="DK">
					    # Sort by Danish
					</button><br><br>

					<input class="search form-control" placeholder="Search" /><br>

					<div class="panel panel-default">
						<table class="table table-hover table-bordered table-striped">
							<thead>
								<tr class="info">
									<th>Row</th>
									<th>Type</th>
									<th>Danish</th>
									<th>English</th>
									<th>French</th>
									<th>Polish</th>
									<th>Spanish</th>
								</tr>
							</thead>
							<tbody class="list">
								@foreach ($words as $word)
									<tr onclick="document.location = '{{ route('word_path', $word->id) }}'">
										<td class="clickable id">{{ $word->id }}</td>
										<td class="clickable type">{{ $word->type }}</td>
										<td title="{{ $word->TSDK }}" class="clickable DK">{{ $word->DK }}</td>
										<td class="clickable EN">{{ $word->EN }}</td>
										<td class="clickable FR">{{ $word->FR }}</td>
										<td title="{{ $word->TSPL }}" class="clickable PL">{{ $word->PL }}</td>
										<td title="{{ $word->TSES }}" class="clickable ES">{{ $word->ES }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<ul class="pagination"></ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<!-- Searchable list with List.js -->
<script src="/js/list.min.js"></script>
<script src="http://listjs.com/no-cdn/list.pagination.js"></script>
<script type="text/javascript">
	$(function() {
	    // console.log( "ready!" );
		var options = {
		  valueNames: [ 'DK', 'FR', 'EN', 'PL', 'ES', 'type', 'id' ],
		  page: 200,
		  plugins: [ ListPagination([]) ]
		};

		var wordList = new List('words', options);
	});
</script>
@endsection