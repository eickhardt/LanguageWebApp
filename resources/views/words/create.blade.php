@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						{!! link_to_route('words_path', 'Words') !!} / Create word
					</h2>
				</div>

				<div class="panel-body">
					{!! Form::open(['url' => route('words_path'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								{!! Form::text('type', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">French</label>
							<div class="col-md-6">
								{!! Form::text('FR', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">English</label>
							<div class="col-md-6">
								{!! Form::text('EN', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Danish</label>
							<div class="col-md-6">
								{!! Form::text('DK', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Polish</label>
							<div class="col-md-6">
								{!! Form::text('PL', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Spanish</label>
							<div class="col-md-6">
								{!! Form::text('ES', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time added DK</label>
							<div class="col-md-6">
								{!! Form::text('TSDK', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time added PL</label>
							<div class="col-md-6">
								{!! Form::text('TSPL', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time added ES</label>
							<div class="col-md-6">
								{!! Form::text('TSES', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									! Create
								</button>
							</div>
						</div>
					{!! Form::close() !!}

					<button onclick="document.location='{{ route('words_path') }}'" type="submit" class="btn btn-primary">
						< Back to words
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection