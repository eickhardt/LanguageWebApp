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


    /**
     * Return all types as a key/value pair array.
     */
    public static function asKeyValuePairs()
    {
    	$types = new WordType;
    	$types = $types->all();

    	$array = [];

    	foreach ($types as $type) 
    	{
    		$array = array_add($array, $type->id, ucfirst($type->name));
    	}

    	return $array;
    }
}
