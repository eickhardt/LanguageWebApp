@extends('app')

@section('content')
	<?php isset($meaning) ? $meaning_id = $meaning->id : $meaning_id = 0; ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2><span class="glyphicon glyphicon-plus-sign"></span> Words / Create</h2>
		</div>

		<div class="panel-body">
			{!! Form::open(['route' => 'word_store_path', 'class' => 'form-horizontal']) !!}
			
				<div class="form-group {{ $errors->has('meaning_id') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Meaning to associate</label>
					<div class="col-md-2">
						{!! Form::text('meaning_id', isset($meaning) ? $meaning->id : '', ['class' => 'form-control', 'id' => 'meaning_id']) !!}
						{!! $errors->first('meaning_id', '<span class="help-block">:message</span>') !!}
					</div>
					<div class="col-md-4">
						{!! Form::text('meaning_english', isset($meaning) ? ucfirst($meaning->english) : '', ['class' => 'form-control', 'disabled', 'id' => 'meaning_english']) !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('word_language_id') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Language</label>
					<div class="col-md-6">
						{!! Form::select('word_language_id', $languages, NULL, ['class' => 'form-control', 'id' => 'type_selector']) !!}
						{!! $errors->first('word_language_id', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Word text</label>
					<div class="col-md-6">
						{!! Form::text('text', NULL, ['class' => 'form-control']) !!}
						{!! $errors->first('text', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-plus-sign"></span> Create
						</button>
					</div>
				</div>
			{!! Form::close() !!}

			<button onclick="document.location='{{ route('search_path') }}'" type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span> Goto search
			</button>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(function() 
		{
			var url = '<?= route('ajax_simple_meaning_path', [], false) ?>';
			var _globalObj = <?= json_encode(array('_token'=> csrf_token())) ?>;
			var token = _globalObj._token;

			$('#meaning_id').bindWithDelay('input propertychange paste', function() 
			{
				meaning_id = $(this).val();
				setMeaningEnglish(meaning_id, url, token);
			}, 200);
		});

		function setMeaningEnglish(meaning_id, url, token) 
		{
			$.ajax({
				type: 'POST',
				url: url,
				data: { meaning_id: meaning_id, _token: token },
				success: function(meaning) {
					$('#meaning_english').val(meaning['english']);
				}
			})
		}
	</script>
@endsection