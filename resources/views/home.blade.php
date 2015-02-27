@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				<span class="glyphicon glyphicon-globe"></span> Home
			</h2>
		</div>

		<div class="panel-body">
			@unless (Auth::guest())
				You are logged in! Word of the day is: <b>{!! link_to_route('meaning_wotd_path', $wotd->english) !!}</b><br><br>
				<div class="list-group">
					<a href="#" class="list-group-item active">
						You have access to the following features:
					</a>
					<a href="{{ route('search_path') }}" class="list-group-item">Dictionary <span class="badge">{{ $wordcount }}</span></a>
				</div>
			@else
				You are not logged in. Log in <a href="/auth/login">here</a>.
			@endunless
		</div>
	</div>
@endsection
