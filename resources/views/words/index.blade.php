@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>
						<a href="/words">Words</a> / Index <span id="waitmsg">/ Wait a second...</span>
					</h2>
				</div>
				<div id="words" class="panel-body">
					<button onclick="document.location='{{ route('word_create_path') }}'" type="submit" class="btn btn-primary">
						+ Create new
					</button><br><br>

					<input id="searchbar" class="form-control" placeholder="Search for..." /><br>
					<div class="table-responsive"> 
						<div id="words_table" class="panel panel-default">
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr class="info">
										<th>Row</th>
										<th>Type</th>
										<th>Danish</th>
										<th>English</th>
										<th>French</th>
										<th>Polish</th>
										<th>Spanish</th>
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
		var list = $('#list');
		var waitmsg = $('#waitmsg');

		$('#searchbar').bindWithDelay('input propertychange paste', function() 
		{
			var value = $(this).val();
			$('.removeme').remove();

			if (value.length > 1)
			{
				$('#words_table').show();
				waitmsg.show();
				$.ajax({
					type: method,
					url: url,
					data: { value: value, _token: token },
					success: function(words) 
					{
						for (var i = 0; i <= words.length -1; i++) 
						{
							var row = $('#cloneme').clone().removeAttr('id').removeAttr('style').attr('onclick', "document.location = '/words/" + words[i]['id'] + "'");

							row.addClass('removeme');

							row.find('.id').html(words[i]['id']);
							row.find('.DK').html(words[i]['DK']);
							row.find('.DK').attr('title', words[i]['TSDK']);
							row.find('.FR').html(words[i]['FR']);
							row.find('.PL').html(words[i]['PL']);
							row.find('.PL').attr('title', words[i]['TSPL']);
							row.find('.ES').html(words[i]['ES']);
							row.find('.ES').attr('title', words[i]['TSES']);
							row.find('.EN').html(words[i]['EN']);
							row.find('.type').html(words[i]['type']);

							row.appendTo($('#list'));
						};
						waitmsg.hide();
					}
				});
			}
			else
			{
				$('#words_table').slideUp();
			}
		}, 200);
	});
</script>
@endsection