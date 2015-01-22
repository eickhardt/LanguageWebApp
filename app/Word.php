<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Word extends Eloquent {

	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'words_all';

	/**
	 * Fillable fields for a word.
	 *
	 * @var array
	 */
	protected $fillable = [
		'DK', 'FR', 'PL', 'EN', 'ES', 'TSES', 'TSDK', 'TSPL', 'type'
	];

}