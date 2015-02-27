@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				<span class="glyphicon glyphicon glyphicon-pencil"></span> Words / Edit / <b>{{ ucfirst($word->text) }}</b>
			</h2>
		</div>

		<div class="panel-body">
			{!! Form::model($word, ['route' => ['word_update_path', $word->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

				<div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Text</label>
					<div class="col-md-6">
						{!! Form::text('text', NULL, ['class' => 'form-control']) !!}
						{!! $errors->first('text', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('word_language_id') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Language</label>
					<div class="col-md-6">
						{!! Form::select('word_language_id', $languages, NULL, ['class' => 'form-control', 'id' => 'type_selector']) !!}
						{!! $errors->first('word_language_id', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('created_at') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Created at</label>
					<div class="col-md-6">
						{!! Form::text('created_at', NULL, ['class' => 'form-control', 'disabled']) !!}
						{!! $errors->first('created_at', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('updated_at') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Updated at</label>
					<div class="col-md-6">
						{!! Form::text('updated_at', NULL, ['class' => 'form-control', 'disabled']) !!}
						{!! $errors->first('updated_at', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-ok-sign"></span> Update
						</button>
					</div>
				</div>
			{!! Form::close() !!}

			{!! Form::open(['route' => ['word_delete_path', $word->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete_word_form']) !!}
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button id="delete_word_btn" type="submit" class="btn btn-primary btn-danger">
							<span class="glyphicon glyphicon-trash"></span> Trash
						</button>
					</div>
				</div>
			{!! Form::close() !!}<br>

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
		$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

		var focus = '{{ Input::get('focus') }}';

		if (focus)
		{
			$( '.' + focus ).focus();
		}

		$( "#delete_word_btn" ).on('click', function(e) 
		{
			$(this).button("disable");
			if (confirm("Are you sure you want to trash this word?"))
			{
				$('#delete_word_form').submit();
			}
			else {

				$(this).button("enable");
			}
			e.preventDefault();
		});
	});
</script>
@endsection