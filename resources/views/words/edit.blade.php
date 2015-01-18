@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						{!! link_to_route('words_path', 'Words') !!} / Edit word: <b>{{ $word->FR }}</b> (FR)
					</h2>
				</div>

				<div class="panel-body">
					{!! Form::model($word, ['url' => route('word_update_path', $word->id), 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
						<?php /*<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								100 {!! Form::radio('type', 100, ['class' => 'form-control']) !!}
								200 {!! Form::radio('type', 200, ['class' => 'form-control']) !!}
								300 {!! Form::radio('type', 300, ['class' => 'form-control']) !!}
								400 {!! Form::radio('type', 400, ['class' => 'form-control']) !!}
								500 {!! Form::radio('type', 500, ['class' => 'form-control']) !!}
							</div>
						</div> */ ?>

						<div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								{!! Form::text('type', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/Denmark.png"></label>
							<div class="col-md-6">
								{!! Form::text('DK', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/USA.png"></label>
							<div class="col-md-6">
								{!! Form::text('EN', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/France.png"></label>
							<div class="col-md-6">
								{!! Form::text('FR', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/Poland.png"></label>
							<div class="col-md-6">
								{!! Form::text('PL', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/Spain.png"></label>
							<div class="col-md-6">
								{!! Form::text('ES', NULL, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time DK</label>
							<div class="col-md-6">
								{!! Form::text('TSDK', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time PL</label>
							<div class="col-md-6">
								{!! Form::text('TSPL', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time ES</label>
							<div class="col-md-6">
								{!! Form::text('TSES', NULL, ['class' => 'form-control datepicker', 'placeholder' => 'Automatically set', 'disabled' => 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									! Update
								</button>
							</div>
						</div>
					{!! Form::close() !!}

					<button onclick="document.location='{{ route('word_path', $word->id) }}'" type="submit" class="btn btn-primary">
						< Back to word
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(function() {
		$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
@endsection