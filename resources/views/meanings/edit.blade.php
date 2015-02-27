@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				<span class="glyphicon glyphicon glyphicon-pencil"></span> Meanings / Edit / <b>{{ ucfirst($meaning->english) }}</b>
			</h2>
		</div>

		<div class="panel-body">
			{!! Form::model($meaning, ['route' => ['meaning_update_path', $meaning->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

				<div class="form-group {{ $errors->has('word_type_id') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Type</label>
					<div class="col-md-6">
						{!! Form::select('word_type_id', $types, $meaning->word_type_id, ['class' => 'form-control', 'id' => 'type_selector']) !!}
						{!! $errors->first('word_type_id', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('real_type') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">Real type</label>
					<div class="col-md-6">
						{!! Form::text('real_word_type', $meaning->real_word_type, ['class' => 'form-control real_type']) !!}
						{!! $errors->first('real_word_type', '<span class="help-block">:message</span>') !!}
					</div>
				</div>

				<div class="form-group {{ $errors->has('english') ? 'has-error' : '' }}">
					<label class="col-md-4 control-label">English</label>
					<div class="col-md-6">
						{!! Form::text('english', NULL, ['class' => 'form-control']) !!}
						{!! $errors->first('english', '<span class="help-block">:message</span>') !!}
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


			{!! Form::open(['route' => ['meaning_delete_path', $meaning->id], 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'delete_word_form']) !!}
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button id="delete_meaning_btn" type="submit" class="btn btn-primary btn-danger">
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
			$('#type_selector').on('change', function() {
				$('.real_type').val($('#type_selector').val() + '00').focus();
			});

			$( "#delete_meaning_btn" ).on('click', function(e) 
			{
				$(this).button("disable");
				if (confirm("Are you sure you want to trash this meaning?"))
				{
					$('#delete_word_form').submit();
				}
				else 
				{
					$(this).button("enable");
				}
				e.preventDefault();
			});
		});
	</script>
@endsection