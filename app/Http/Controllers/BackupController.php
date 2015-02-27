<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BackupController extends Controller {

	/**
	 * Backup the words_all table.
	 *
	 * @return mixed
	 */
	public function backup()
	{
		// Get the words_all table in json form
		$json_data = Word::all()->toJson();

		// Create the name of the file we are going to store
		$storage_file = storage_path().'/data/backups/wordsBackup'.time().'.json';

		// Write the json data to the new file
		$bytes_written = File::put($storage_file, $json_data);
		if ($bytes_written === false)
		{
		    die("Error writing to storage file");
		}

		// Serve the download
        $headers = ['Content-Type: application/json'];
        return Response::download($storage_file, 'LanguageLearningBackup'.time().'.json', $headers);
	}
}
