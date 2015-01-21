@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						{!! link_to_route('words_path', 'Words') !!} / Statistics
					</h2>
				</div>

				<div class="panel-body">

					<h3>Recently added words count</h3>

					<div class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="active">
										<th></th>
										<th>{{ date('Y-m-d', strtotime('-6 day', time())) }}</th>
										<th>{{ date('Y-m-d', strtotime('-5 day', time())) }}</th>
										<th>{{ date('Y-m-d', strtotime('-4 day', time())) }}</th>
										<th>{{ date('Y-m-d', strtotime('-3 day', time())) }}</th>
										<th>{{ date('Y-m-d', strtotime('-2 day', time())) }}</th>
										<th>Yesterday</th>
										<th>Today</th>
									</tr>
								</thead>
								@foreach ($recent_words_data as $key => $fields)
									<tr>
										<td class="active">{{ $key }}</td>

										@foreach ($fields as $field)
										<td>
											{{ $field }}
										</td>
										@endforeach
									</tr>

								@endforeach
								<?php /*
								<tr>
									<td class="active">Danish</td>
									<?php /* @foreach ($words_added as $fields)
										<td>{{ $field }}</td>
									@endforeach 
								</tr>
								<tr><td class="active">Polish</td> </tr>
								<tr><td class="active">Spanish</td> </tr> */ ?>
							</table>
						</div>
					</div>

					<h3>General statistics</h3>

					<div class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="active">
										<th></th>
										<th>Total</th>
										<th>Nouns</th>
										<th>Adjectives</th>
										<th>Verbs</th>
										<th>Other</th>
										<th>%</th>
									</tr>
								</thead>
								@foreach ($statistics_data as $fields)
									<?php $count = 0; ?>
									<tr>
										@foreach ($fields as $field)
											@if ($count == 0)
												<td class="active">{{ $field }}</td>
											@else
												<td>{{ $field }}</td>
											@endif
											<?php $count++; ?>
										@endforeach
									</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection