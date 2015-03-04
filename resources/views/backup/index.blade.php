@extends('app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
				<span class="glyphicon glyphicon-hdd"></span> Backup
			</h2>
		</div>
		<div class="panel-body">

			<div class="panel panel-default">
				<div class="panel-body">

					<p>This is the page where we handle the backups. A backup is an .sql snapshot of the current state of the database. Click the button below to perform a backup, and be served a download of the snapshot.</p>

					<p>Backups are also generated every night at 00:00, and saved on the server. To increase backup safety, use the backup button regularly.</p>

					<button onclick="document.location='{{ route('backup_path') }}'" type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-save"></span> Backup now
					</button>

				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="search_settings_header"><span class="glyphicon glyphicon-info-sign"></span> Recent backups</h3>
				</div>
				<div class="panel-body">
					Panel body
				</div>
			</div>
			<button onclick="document.location='{{ route('search_path') }}'" type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-search"></span> Goto search
			</button>
		</div>
	</div>
@endsection