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
					{!! Form::model($word, ['route' => ['word_update_path', $word->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

						<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6">
								{!! Form::text('type', NULL, ['class' => 'form-control type']) !!}
								{!! $errors->first('type', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group {{ $errors->has('EN') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label"><img src="/img/flags/EN.png"></label>
							<div class="col-md-6">
								{!! Form::text('EN', NULL, ['class' => 'form-control EN']) !!}
								{!! $errors->first('EN', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group {{ $errors->has('FR') ? 'has-error' : '' }}">
							<label class="col-md-4 control-label"><img src="/img/flags/FR.png"></label>
							<div class="col-md-6">
								{!! Form::text('FR', NULL, ['class' => 'form-control FR']) !!}
								{!! $errors->first('FR', '<span class="help-block">:message</span>') !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/DK.png"></label>
							<div class="col-md-6">
								{!! Form::text('DK', NULL, ['class' => 'form-control DK']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/PL.png"></label>
							<div class="col-md-6">
								{!! Form::text('PL', NULL, ['class' => 'form-control PL']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"><img src="/img/flags/ES.png"></label>
							<div class="col-md-6">
								{!! Form::text('ES', NULL, ['class' => 'form-control ES']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time DK</label>
							<div class="col-md-6">
								{!! Form::text('TSDK', NULL, ['class' => 'form-control datepicker TSDK', 'placeholder' => 'Automatically set', $word->TSDK ? '' : 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time PL</label>
							<div class="col-md-6">
								{!! Form::text('TSPL', NULL, ['class' => 'form-control datepicker TSPL', 'placeholder' => 'Automatically set', $word->TSPL ? '' : 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Time ES</label>
							<div class="col-md-6">
								{!! Form::text('TSES', NULL, ['class' => 'form-control datepicker TSES', 'placeholder' => 'Automatically set', $word->TSES ? '' : 'disabled']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									<span class="glyphicon glyphicon-ok-sign"></span> Update
								</button>
							</div>
						</div>
					{!! Form::close() !!}

					{!! Form::open(['route' => ['word_delete_path', $word->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete_word_form']) !!}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button id="delete_word_btn" type="submit" class="btn btn-primary btn-danger">
									<span class="glyphicon glyphicon-remove-sign"></span> Delete
								</button>
							</div>
						</div>
					{!! Form::close() !!}<br>

					<button onclick="document.location='{{ route('words_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-arrow-left"></span> Back to words
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

		var focus = '{{ Input::get('focus') }}';

		if (focus)
		{
			$( '.' + focus ).focus();
		}

		$( "#delete_word_btn" ).on('click', function(e) 
		{
			$(this).button("disable");
			if (confirm("Are you sure you want to delete this word? This action cannot be undone."))
			{
				$('#delete_word_form').submit();
			}
			else {

				$(this).button("enable");
			}
			e.preventDefault();
		})
	});
</script>
@endsection