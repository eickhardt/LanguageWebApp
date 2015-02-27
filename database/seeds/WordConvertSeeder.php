<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\WordN;
use App\WordMeaning;
use App\WordLanguage;

class WordConvertSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Clean tables
		DB::table('words')->delete();
		DB::table('word_meanings')->delete();
		DB::table('word_word_meaning')->delete();

		// The path where the stored files are
		$backup_path = storage_path().'/data/backups/';

		// Grab the most recent file
		$files = scandir($backup_path, SCANDIR_SORT_DESCENDING);
		$newest_file = $files[0];
		$wordsJson = File::get($backup_path.$newest_file);

		// Decode the Json into objects
		$words = json_decode($wordsJson);

		// Array of current languages to iterate over
		$languages = WordLanguage::all();

		// Count the words we are creating
		$count = 0;

		// Go through the word objects one by one<
		foreach ($words as $word) 
		{
			// Create the meaning of the word first
			$meaning = WordMeaning::create([
				'english' 			=> $word->EN, 
				'word_type_id' 		=> substr($word->type, 0, 1) > 5 ? 5 : substr($word->type, 0, 1), 
				'real_word_type'	=> $word->type
			]);

			// Go through the languages one by one
			if ($word->FR) 
			{
				$this->dothis($word->FR, 'fr', $meaning, $word);
			}
			if ($word->EN) 
			{
				$this->dothis($word->EN, 'en', $meaning, $word);
			}
			if ($word->DK) 
			{
				$this->dothis($word->DK, 'dk', $meaning, $word);
			}
			if ($word->ES) 
			{
				$this->dothis($word->ES, 'es', $meaning, $word);
			}
			if ($word->PL) 
			{
				$this->dothis($word->PL, 'pl', $meaning, $word);
			}
		}

		// Set the word of the day
    	Artisan::call('setwordofday');
	}

	// Hmm..
	public function dothis($text, $lang, $meaning, $word) 
	{
		$lang == 'dk' ? $get_lang = 'da' : $get_lang = $lang;
		$language_id = WordLanguage::where('short_name', $get_lang)->first()->id;

		// If the language is English or French, we will set the created_at field as now. Otherwise we use the already stored values.
		if ($lang == 'en' || $lang == 'fr')
		{
			$datetime = date('Y-m-d H:i:s');
		}
		else
		{
			$fieldname = 'TS'.strtoupper($lang);
			$date = new DateTime($word->{$fieldname});
			$datetime = $date->format('Y-m-d H:i:s');
		}

		// If the word is found, create it
		$word = WordN::create([
			'word_language_id' 	=> $language_id,
			'text' 				=> $text,
			'created_at' 		=> $datetime,
		]);
		$meaning->words()->attach($word->id);
		// $word->meanings()->attach($meaning->id);
	}
}