<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;

class WordN extends Model {

	/**
	 * This model soft deletes.
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];


	/**
	 * Fillable fields for a word.
	 *
	 * @var array
	 */
	protected $fillable = [
		'word_language_id', 'text'
	];


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'words';


	/**
	 * A Word is in one language.
	 */
	public function language()
    {
        return $this->belongsTo('App\WordLanguage', 'word_language_id', 'id');
        // return $this->hasOne('Phone', 'foreign_key', 'local_key');
        // return $this->hasOne('App\WordLanguage');
    }


	/**
	 * A Word is of one type. (no not atm)
	 */
	// public function type()
    // {
        // return $this->belongsTo('App\WordType');
    // }


    /**
	 * A Word may have many meanings related to it.
	 */
	public function meanings()
    {
        return $this->belongsToMany('App\WordMeaning', 'word_word_meaning', 'word_meaning_id', 'word_id')
        			->whereNull('word_word_meaning.deleted_at');
    }


    /**
	 * Grab a random word with it's language and meanings
	 */
	public static function random()
    {
    	$word = new WordN;
    	$word = $word->with('meanings')->with('language')->orderBy(DB::raw('RAND()'))->first();
        return $word;
    }

}
