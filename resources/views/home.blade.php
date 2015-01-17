@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					@unless (Auth::guest())
						You are logged in!<br><br>

						<div class="list-group">
							<a href="#" class="list-group-item active">
								You have access to the following features:
							</a>
							<a href="/words" class="list-group-item">Words<span class="badge">{{ $wordcount }}</span></a>
							<!-- <a href="#" class="list-group-item">Morbi leo risus</a>
							<a href="#" class="list-group-item">Porta ac consectetur ac</a>
							<a href="#" class="list-group-item">Vestibulum at eros</a> -->
						</div>
					@else
						You are not logged in. Log in <a href="/auth/login">here</a>.
					@endunless
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
