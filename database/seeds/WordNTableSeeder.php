<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\WordN;
use App\WordMeaning;

class WordNTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// DB::table('words')->delete();
		// DB::table('word_meanings')->delete();
		// DB::table('word_word_meaning')->delete();

		// $meaning = WordMeaning::create(['english' => 'to have', 'word_type_id' => 1]);
		// $word = WordN::create([
		// 	'word_language_id' => 1,
		// 	'text' => 'to have'
		// ]);
		// $meaning->words()->attach($word->id);
		// $word = WordN::create([
		// 	'word_language_id' => 3,
		// 	'text' => 'at have'
		// ]);
		// $meaning->words()->attach($word->id);

		// $meaning = WordMeaning::create(['english' => 'to see', 'word_type_id' => 2]);
		// $word = WordN::create([
		// 	'word_language_id' => 1,
		// 	'text' => 'to see'
		// ]);
		// $meaning->words()->attach($word->id);
		// $word = WordN::create([
		// 	'word_language_id' => 3,
		// 	'text' => 'at se'
		// ]);
		// $meaning->words()->attach($word->id);

		// $meaning = WordMeaning::create(['english' => 'to go', 'word_type_id' => 3]);
		// $word = WordN::create([
		// 	'word_language_id' => 1,
		// 	'text' => 'to go'
		// ]);
		// $meaning->words()->attach($word->id);
		// $word = WordN::create([
		// 	'word_language_id' => 3,
		// 	'text' => 'at tage afsted'
		// ]);
		// $meaning->words()->attach($word->id);

    	// Artisan::call('setwordofday');
	}
}
