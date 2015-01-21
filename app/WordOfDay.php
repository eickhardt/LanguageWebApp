<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WordOfDay extends Eloquent {

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

	public $timestamps = false;

}