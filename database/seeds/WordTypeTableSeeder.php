<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\WordType;

class WordTypeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('word_types')->delete();

		WordType::create([
			'name' => 'adjective'
		]);

		WordType::create([
			'name' => 'noun'
		]);

		WordType::create([
			'name' => 'verb'
		]);

		WordType::create([
			'name' => 'adverb'
		]);

		WordType::create([
			'name' => 'other'
		]);
	}

}
