@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						<a href="/words">Words</a> / Index 
						<span id="waitmsg">/ Wait a second...</span>
					</h2>
				</div> 
				<div id="words" class="panel-body">
					<button onclick="document.location='{{ route('word_create_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus-sign"></span> Create new
					</button>
					<button onclick="document.location='{{ route('word_wotd_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-certificate"></span> Word of the Day
					</button>
					<button onclick="document.location='{{ route('word_random_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-question-sign"></span> Random word
					</button>
					<button onclick="document.location='{{ route('word_statistics_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-stats"></span> Statistics
					</button>
					<button onclick="document.location='{{ route('word_backup_path') }}'" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-download"></span> Backup
					</button>
					<br><br>

					<?php /*
					<button id="advanced_search_btn" type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-dashboard"></span> Advanced search
					</button>

					<div id="search_settings" class="panel panel-default">
						<div class="panel-heading">
							Advanced search settings
						</div>
						<div class="panel-body">
							<h4>Languages</h4>
							<div class="well well-sm">
								<span class="search_language"><img src="/img/flags/DK.png"> {!! Form::checkbox('DK', 'DK', true) !!}</span>
								<span class="search_language"><img src="/img/flags/EN.png"> {!! Form::checkbox('EN', 'EN', true) !!}</span>
								<span class="search_language"><img src="/img/flags/FR.png"> {!! Form::checkbox('FR', 'FR', true) !!}</span>
								<span class="search_language"><img src="/img/flags/PL.png"> {!! Form::checkbox('PL', 'PL', true) !!}</span>
								<span class="search_language"><img src="/img/flags/ES.png"> {!! Form::checkbox('ES', 'ES', true) !!}</span>
							</div>
						</div>
					</div>*/ ?>

					<input id="searchbar" class="form-control" placeholder="Search for..." /><br>
					<div id="words_table" class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="active">
										<th>Row</th>
										<th>Type</th>
										<th><img src="/img/flags/DK.png"></th>
										<th><img src="/img/flags/EN.png"></th>
										<th><img src="/img/flags/FR.png"></th>
										<th><img src="/img/flags/PL.png"></th>
										<th><img src="/img/flags/ES.png"></th>
									</tr>
								</thead>
								<tbody id="list">
									<tr id="cloneme" style="display:none;">
										<td class="clickable id"></td>
										<td class="clickable type"></td>
										<td title="" class="clickable DK"></td>
										<td class="clickable EN"></td>
										<td class="clickable FR"></td>
										<td title="" class="clickable PL"></td>
										<td title="" class="clickable ES"></td>
									</tr>
									<tr id="noresult"><td colspan="7">There seems to be nothing here.</td></tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<!-- Searchable list -->
<script type="text/javascript">
	$(function() 
	{
		// Show advanced options when the corresponsing button is clicked
		// $('#advanced_search_btn').on('click', function() 
		// {
		// 	$('#search_settings').slideToggle();
		// });

		var method = 'POST';
		var url = '/words/search';
		var _globalObj = <?= json_encode(array('_token'=> csrf_token())) ?>;
		var token = _globalObj._token;

		if ($('#searchbar').val().length > 1)
		{
			var value = $('#searchbar').val();
			updateList(value, token, method, url);
		}

		$('#searchbar').bindWithDelay('input propertychange paste', function() 
		{
			var value = $('#searchbar').val();
			updateList(value, token, method, url);
		}, 200);
	});

	function updateList(value, token, method, url) {
		$('.removeme').remove();

		if (value.length > 1)
		{
			$('#words_table').hide();
			$('#waitmsg').show();
			$.ajax({
				type: method,
				url: url,
				data: { value: value, _token: token },
				success: function(words) 
				{
					if (words.length > 0)
					{
						for (var i = 0; i <= words.length -1; i++) 
						{
							var row = $('#cloneme').clone().removeAttr('id').removeAttr('style');

							row.addClass('removeme');

							row.find('.id').html(words[i]['id']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit'");
							row.find('.type').html(words[i]['type']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=type'");

							row.find('.DK').html(words[i]['DK']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=DK'");
							row.find('.FR').html(words[i]['FR']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=FR'");
							row.find('.PL').html(words[i]['PL']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=PL'");
							row.find('.ES').html(words[i]['ES']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=ES'");
							row.find('.EN').html(words[i]['EN']).attr('onclick', "document.location = '/words/" + words[i]['id'] + "/edit?focus=EN'");

							row.find('.PL').attr('title', words[i]['TSPL']);
							row.find('.ES').attr('title', words[i]['TSES']);
							row.find('.DK').attr('title', words[i]['TSDK']);

							row.appendTo($('#list'));
						};
						$('#noresult').hide();
					} 
					else 
					{
						$('#noresult').show();
					}
					$('#waitmsg').hide();
					$('#words_table').slideDown();
				}
			});
		}
		else
		{
			$('#words_table').slideUp();
		}
	}
</script>
@endsection