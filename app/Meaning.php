<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meaning extends Model {

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
		'word_type_id', 'real_word_type', 'english', 
		'created_at', 'updated_at', 'deleted_at'
	];


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'meanings';


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
		return $this->hasMany('App\Word');
		// return $this->belongsToMany('App\WordN', 'word_word_meaning', 'word_id', 'word_meaning_id')
					// ->whereNull('word_word_meaning.deleted_at');
	}


	/**
	 * A WordLanguage has many words related to it.
	 */
	public function type()
	{
		// return $this->hasOne('App\WordType');
		return $this->belongsTo('App\WordType', 'word_type_id', 'id');
	}


	/**
	 * Get a random meaning wwith it's related words
	 */
	public static function random()
	{
		$meaning = new Meaning();

		return $meaning->with('words')->orderByRaw("RAND()")->first();
	}

}
