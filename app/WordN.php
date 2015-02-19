<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WordN extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'words';

	/**
	 * This model soft deletes.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * A Word is in one language.
	 */
	public function language()
    {
        return $this->hasOne('App\WordLanguage');
    }

	/**
	 * A Word is of one type.
	 */
	public function type()
    {
        return $this->hasOne('App\WordType');
    }

    /**
	 * A Word may have many meanings related to it.
	 */
	public function meanings()
    {
        return $this->belongsToMany('App\WordMeaning', 'word_word_meaning', 'word_meaning_id', 'word_id');
    }

}
