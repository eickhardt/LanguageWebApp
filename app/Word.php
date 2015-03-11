<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Eloquent {

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
		'word_language_id', 'text', 'meaning_id'
	];


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
	 * A Word belongs to a meaning.
	 */
	public function meaning()
    {
    	return $this->belongsTo('App\Meaning');
        // return $this->belongsToMany('App\WordMeaning', 'word_word_meaning', 'word_meaning_id', 'word_id')
        			// ->whereNull('word_word_meaning.deleted_at');
    }


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'words_redesigned';


    /**
	 * Grab a random word with it's language and meanings
	 */
	public static function random()
    {
    	$word = new WordN;
    	$word = $word->with('meaning')->with('language')->orderBy(DB::raw('RAND()'))->first();
        return $word;
    }
}