<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WordOfDay extends Eloquent {

	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'word_of_day';

	/**
	 * This has a word associated.
	 */
	public function word()
    {
        return $this->hasOne('App\Word', 'id', 'word_id');
    }

	/**
	 * Get the current word of the day as an instance of Word.
	 */
	public function getCurrent()
	{
		return $this->orderBy('date', 'DESC')->first()->word;
	}

}