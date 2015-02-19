<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WordMeaning extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'word_meanings';

	/**
	 * This model soft deletes.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * A WordLanguage has many words related to it.
	 */
	public function words()
    {
        return $this->belongsToMany('App\WordN', 'word_word_meaning', 'word_meaning_id', 'word_id');
    }

    /**
	 * Get a random meaning wwith it's related words
	 */
	public static function random()
    {
    	$meaning = new WordMeaning();

    	return $meaning->with('words')->orderByRaw("RAND()")->first();
    }

}
