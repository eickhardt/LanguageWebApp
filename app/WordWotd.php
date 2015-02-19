<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\WordN;

class WordWotd extends Model {

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
	protected $table = 'word_wotds';

	/**
	 * A word of the day has one meaning.
	 */
	public function meaning()
    {
        return $this->belongsTo('App\WordMeaning');
    }

	/**
	 * Get the current word of the day as an instance of Word.
	 */
	public static function getCurrent($language = 1)
	{
		$wotd = new WordWotd();
		$wotd = $wotd->orderBy('date', 'DESC')->first();

		$words = WordMeaning::with('words')->find($wotd->word_meaning_id);

		return $words;
	}

}
