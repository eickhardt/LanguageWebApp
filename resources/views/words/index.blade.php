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
						+ Create new
					</button>
					<button onclick="document.location='{{ route('word_random_path') }}'" type="submit" class="btn btn-primary">
						? Random word
					</button><br><br>

					<input id="searchbar" class="form-control" placeholder="Search for..." /><br>
					<div id="words_table" class="panel panel-default">
						<div class="table-responsive"> 
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="active">
										<th>Row</th>
										<th>Type</th>
										<th><img src="/img/flags/Denmark.png"></th>
										<th><img src="/img/flags/USA.png"></th>
										<th><img src="/img/flags/France.png"></th>
										<th><img src="/img/flags/Poland.png"></th>
										<th><img src="/img/flags/Spain.png"></th>
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
		var method = 'POST';
		var url = '/words/search';
		var _globalObj = <?= json_encode(array('_token'=> csrf_token())) ?>;
		var token = _globalObj._token;
		// var list = $('#list');

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