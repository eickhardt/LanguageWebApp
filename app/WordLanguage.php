<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WordLanguage extends Model {

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
	protected $table = 'word_languages';

	/**
	 * A WordLanguage has many words related to it.
	 */
	public function words()
    {
        return $this->hasMany('App\WordN');
    }

}
