<?php namespace App;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use DB;

class Backup extends Model {

	/**
	 * This model soft deletes.
	 */
	// use SoftDeletes;
	// protected $dates = ['deleted_at'];


	/**
	 * Fillable fields for a word.
	 *
	 * @var array
	 */
	protected $fillable = [
		'file', 'user_id', 'created_at', 'updated_at'
	];


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'backups';


	/**
	 * A Word is in one language.
	 */
	public function user()
    {
        return $this->belongsTo('App\User');
    }

}
