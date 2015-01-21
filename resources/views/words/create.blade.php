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
					{!! Form::open(['route' => 'word_store_path', 'class' => 'form-horizontal']) !!}

						<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								{!! Form::text('type', NULL, ['class' => 'form-control']) !!}
								{!! $errors->first('type', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group {{ $errors->has('EN') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label"><img src="/img/flags/EN.png"></label>
							<div class="col-md-6">
								{!! Form::text('EN', NULL, ['class' => 'form-control']) !!}
								{!! $errors->first('EN', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group {{ $errors->has('FR') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label"><img src="/img/flags/FR.png"></label>
							<div class="col-md-6">
								{!! Form::text('FR', NULL, ['class' => 'form-control']) !!}
								{!! $errors->first('FR', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/DK.png"></label>
							<div class="col-md-6">
								{!! Form::text('DK', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/PL.png"></label>
							<div class="col-md-6">
								{!! Form::text('PL', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/ES.png"></label>
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
									<span class="glyphicon glyphicon-plus-sign"></span> Create
								</button>
							</div>
						</div>
					{!! Form::close() !!}

					<button onclick="document.location='{{ route('words_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-arrow-left"></span> Back to words
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection