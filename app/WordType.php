<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WordType extends Model {

	/**
	 * This model does not have timestamps.
	 *
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'word_types';

	/**
	 * A type covers many words.
	 */
	public function wordMeanings()
    {
        return $this->hasMany('App\WordMeaning');
    }

}
