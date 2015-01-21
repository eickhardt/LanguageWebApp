<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Word;
use App\WordOfDay;

class SelectWordOfDay extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setwordofday';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Select a random word and set it as the word of the day.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Pick a random word from the words_all table
		$word = Word::orderByRaw("RAND()")->take(1)->first();

		// Add it as a word of the day
		$word_of_day = new WordOfDay();
		$word_of_day->word_id = $word->id;
		$word_of_day->date = date('Y-m-d');
		$word_of_day->save();

		$this->info('Word of the day has been set.');
	}

}
