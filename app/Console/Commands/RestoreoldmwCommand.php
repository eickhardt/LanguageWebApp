<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;
use File;
use Illuminate\Support\Facades\Storage;

use App\Word;
use App\Meaning;

class RestoreoldmwCommand extends Command {


	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'restoreoldmw';


	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Restores Meaning/Word data from json to new tables.';


	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Starting restore old MW command.');

		// The path where the stored files are
		$meanings_file_path = storage_path().'/app/meanings.json';
		$meanings_json = File::get($meanings_file_path);

		// Decode the Json into objects
		$meanings = json_decode($meanings_json);
		$meanings_count = 0;

		$this->info('Creating the new meanings.');
		foreach ($meanings as $meaning) 
		{
			// dd($meaning);
			$meanings_count++;
			Meaning::create([
				'word_type_id' => $meaning->word_type_id,
				'real_word_type' => $meaning->real_word_type,
				'english' => $meaning->english,
				'created_at' => $meaning->created_at,
				'updated_at' => $meaning->updated_at,
			]);
		}
		$this->info('Meanings ('.$meanings_count.') done.');

		// The path where the stored files are
		$words_file_path = storage_path().'/app/words.json';
		$words_json = File::get($words_file_path);

		// Decode the Json into objects
		$words = json_decode($words_json);
		$words_count = 0;

		$this->info('Creating the new words.');
		foreach ($words as $word) 
		{
			$words_count++;
			Word::create([
				'word_language_id' => $word->word_language_id,
				'text' => $word->text,
				'meaning_id' => $word->meaning_id,
				'created_at' => $word->created_at,
				'updated_at' => $word->updated_at,
				'deleted_at' => $word->deleted_at,
			]);
		}
		$this->info('Words ('.$words_count.') done.');
	}

}
