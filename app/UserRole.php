<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_roles';

	/**
	 * A user can have many UserRoles associated with it.
	 */
	public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
