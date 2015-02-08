<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Controllers\Controller;
use App\Word;
use App\WordOfDay;
use Session;
use File;
use Auth;
use DB;
use Input;
use Response;
use Debugbar;

class WordsController extends Controller {


	/**
	 * @var word
	 */
	private $word;


	/**
	 * @var languages
	 */
	private $languages = ['DK', 'ES', 'PL'];


	/**
	 * Constructor
	 *
	 * @param Word $word
	 */
	public function __construct(Word $word)
	{
		$this->middleware('auth');

		$this->word = $word;
	}


	/**
	 * Show a listing of all words.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function index()
	{
		return view('words.index');
	}


	/**
	 * Show an individual word.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function show(Word $word)
	{
		$words[] = $word;

		$list_type = 'Word: '. $word->FR;

		return view('words.list', compact('words', 'list_type'));
	}


	/**
	 * Show the edit page for a specific word.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function edit(Word $word)
	{
		return view('words.edit', compact('word'));
	}


	/**
	 * Update a word.
	 *
	 * @param CreateWordRequest $request
	 * @param Word $word
	 * @return mixed
	 */
	public function update(UpdateWordRequest $request, Word $word)
	{
		$word->TSDK = $request->get('TSDK') ?: NULL;
		$word->TSPL = $request->get('TSPL') ?: NULL;
		$word->TSES = $request->get('TSES') ?: NULL;

		// If a word is emtpy in DK PL or ES and is now being set, also set corresponding date
		foreach ($this->languages as $field) 
		{
			if ($word->$field == NULL)
			{
				if ($request->get($field))
				{
					$word->$field = $request->get($field);
					$timefield = 'TS'.$field;
					$word->$timefield = date('Y-m-d');
				}
			}
			else
			{
				$word->$field = $request->get($field) ?: NULL;
			}
		}

		// Set the rest of the fields
		$word->FR = $request->get('FR');
		$word->EN = $request->get('EN');
		$word->type = $request->get('type');
		$word->update();

		Session::flash('success', "The word '".$word->FR."' was updated.");
		return redirect()->route('word_edit_path', $word->id);
	}


	/**
	 * Show form for creating a new word.
	 *
	 * @return mixed
	 */
	public function create()
	{
		return view('words.create');
	}


	/**
	 * Store a new word.
	 *
	 * @param CreateWordRequest $request
	 * @return mixed
	 */
	public function store(CreateWordRequest $request)
	{
		// If this code is executed, validation has passed and we can create the word.
		$word = new Word;

		$word->type = $request->get('type');

		$word->FR = $request->get('FR');
		$word->EN = $request->get('EN');
		$word->DK = $request->get('DK') ?: NULL ;
		$word->ES = $request->get('ES') ?: NULL ;
		$word->PL = $request->get('PL') ?: NULL ;

		foreach ($this->languages as $field) 
		{
			if ($request->get($field))
			{
				$timefield = 'TS'.$field;
				$word->$timefield = date('Y-m-d');
			}
		}
		$word->save();

		Session::flash('success', "A new word '".$word->FR."' was created.");
		return redirect()->route('word_edit_path', $word->id);
	}


	/**
	 * Delete a word
	 *
	 * @param Word $word
	 * @return mixed
	 */
	public function destroy(Word $word)
	{
		$user = Auth::user();

		$allowed_users = ['Daniel Eickhardt', 'Gabrielle Tranchet'];

		if (!in_array($user->name, $allowed_users))
		{
			Session::flash('error', "You don't have permission to do that.");
			return redirect()->back();
		}

		$oldword = $word->FR;
		$word->delete();

		Session::flash('success', "The word '" .$oldword. "' was deleted.");
		return redirect()->route('words_path');
	}


	/**
	 * Search for a word.
	 *
	 * @param String $value  The value to search for.
	 * @return mixed
	 */
	public function search()
	{
		if (Input::has('value'))
		{
			$string = Input::get('value');
			$string = "%{$string}%";

			$words = Word::where('FR', 'LIKE', $string)
				->orWhere('EN', 'LIKE', $string)
				->orWhere('DK', 'LIKE', $string)
				->orWhere('PL', 'LIKE', $string)
				->orWhere('ES', 'LIKE', $string)
				->orWhere('EN', 'LIKE', $string)
				->orWhere('type', 'LIKE', $string)
				->orWhere('id', 'LIKE', $string)
				->get();

			return $words->toArray();
		}
		return false;
	}


	/**
	 * Show a random word.
	 *
	 * @return mixed
	 */
	public function random()
	{
		$words = Word::orderByRaw("RAND()")->take(1)->get();

		$list_type = 'Random word';

		return view('words.list', compact('words', 'list_type'));
	}


	/**
	 * Backup the words_all table.
	 *
	 * @return mixed
	 */
	public function backup()
	{
		// Get the words_all table in json form
		$json_data = Word::all()->toJson();

		// Create the name of the file we are going to store
		$storage_file = storage_path().'/data/backups/wordsBackup'.time().'.json';

		// Write the json data to the new file
		$bytes_written = File::put($storage_file, $json_data);
		if ($bytes_written === false)
		{
		    die("Error writing to storage file");
		}

		// Serve the download
        $headers = ['Content-Type: application/json'];
        return Response::download($storage_file, 'LanguageLearningBackup'.time().'.json', $headers);
	}


	/**
	 * Display Word of the Day.
	 *
	 * @return mixed
	 */
	public function wotd()
	{
		$words = [];

		$word = new WordOfDay();
		$words[] = $word->getcurrent();

		$list_type = 'Word of the Day';

		return view('words.list', compact('words', 'list_type'));
	}


	/**
	 * Show a page with statistics about words.
	 *
	 * @return mixed
	 */
	public function statistics()
	{
		$statistics_data = [];

		// Totals
		$statistics_data['total']['name'] = 'All';
		$statistics_data['total']['total_all'] = '';
		$statistics_data['total']['total_adjectives'] = '';
		$statistics_data['total']['total_nouns'] = '';
		$statistics_data['total']['total_verbs'] = '';
		$statistics_data['total']['total_other'] = '';
		$statistics_data['total']['total_percent'] = '';

		// English
		$statistics_data['EN']['name'] = 'English';
		$statistics_data['EN']['total_all'] = Word::where('EN', '!=', '')->count();
		$statistics_data['EN']['total_adjectives'] = Word::where('EN', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['EN']['total_nouns'] = Word::where('EN', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['EN']['total_verbs'] = Word::where('EN', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['EN']['total_other'] = Word::where('EN', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();

		// French
		$statistics_data['FR']['name'] = 'French';
		$statistics_data['FR']['total_all'] = Word::where('FR', '!=', '')->count();
		$statistics_data['FR']['total_adjectives'] = Word::where('FR', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['FR']['total_nouns'] = Word::where('FR', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['FR']['total_verbs'] = Word::where('FR', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['FR']['total_other'] = Word::where('FR', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();

		// Danish
		$statistics_data['DK']['name'] = 'Danish';
		$statistics_data['DK']['total_all'] = Word::where('DK', '!=', '')->count();
		$statistics_data['DK']['total_adjectives'] = Word::where('DK', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['DK']['total_nouns'] = Word::where('DK', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['DK']['total_verbs'] = Word::where('DK', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['DK']['total_other'] = Word::where('DK', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();

		// Polish
		$statistics_data['PL']['name'] = 'Polish';
		$statistics_data['PL']['total_all'] = Word::where('PL', '!=', '')->count();
		$statistics_data['PL']['total_adjectives'] = Word::where('PL', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['PL']['total_nouns'] = Word::where('PL', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['PL']['total_verbs'] = Word::where('PL', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['PL']['total_other'] = Word::where('PL', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();

		// Spanish
		$statistics_data['ES']['name'] = 'Spanish';
		$statistics_data['ES']['total_all'] = Word::where('ES', '!=', '')->count();
		$statistics_data['ES']['total_adjectives'] = Word::where('ES', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['ES']['total_nouns'] = Word::where('ES', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['ES']['total_verbs'] = Word::where('ES', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['ES']['total_other'] = Word::where('ES', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();

		// The total sum of words
		$statistics_data['total']['total_all'] = $statistics_data['EN']['total_all'] + $statistics_data['FR']['total_all'] + $statistics_data['DK']['total_all'] + $statistics_data['PL']['total_all'] + $statistics_data['ES']['total_all'];
		$statistics_data['total']['total_adjectives'] = $statistics_data['EN']['total_adjectives'] + $statistics_data['FR']['total_adjectives'] + $statistics_data['DK']['total_adjectives'] + $statistics_data['PL']['total_adjectives'] + $statistics_data['ES']['total_adjectives'];
		$statistics_data['total']['total_nouns'] = $statistics_data['EN']['total_nouns'] + $statistics_data['FR']['total_nouns'] + $statistics_data['DK']['total_nouns'] + $statistics_data['PL']['total_nouns'] + $statistics_data['ES']['total_nouns'];
		$statistics_data['total']['total_verbs'] = $statistics_data['EN']['total_verbs'] + $statistics_data['FR']['total_verbs'] + $statistics_data['DK']['total_verbs'] + $statistics_data['PL']['total_verbs'] + $statistics_data['ES']['total_verbs'];
		$statistics_data['total']['total_other'] = $statistics_data['EN']['total_other'] + $statistics_data['FR']['total_other'] + $statistics_data['DK']['total_other'] + $statistics_data['PL']['total_other'] + $statistics_data['ES']['total_other'];

		$statistics_data['EN']['total_percent'] = round( $statistics_data['EN']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );
		$statistics_data['FR']['total_percent'] = round( $statistics_data['FR']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );
		$statistics_data['DK']['total_percent'] = round( $statistics_data['DK']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );
		$statistics_data['PL']['total_percent'] = round( $statistics_data['PL']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );
		$statistics_data['ES']['total_percent'] = round( $statistics_data['ES']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );


		// Combinations of languages
		// Danish and Polish and Spanish
		$statistics_data['DK_PL_ES']['name'] = 'DK + PL + ES';
		$statistics_data['DK_PL_ES']['total_all'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('ES', '!=', '')->count();
		$statistics_data['DK_PL_ES']['total_adjectives'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('ES', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['DK_PL_ES']['total_nouns'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('ES', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['DK_PL_ES']['total_verbs'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('ES', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['DK_PL_ES']['total_other'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('ES', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['DK_PL_ES']['total_percent'] = round( $statistics_data['DK_PL_ES']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );

		// Danish and Polish
		$statistics_data['DK_PL']['name'] = 'DK + PL';
		$statistics_data['DK_PL']['total_all'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->count();
		$statistics_data['DK_PL']['total_adjectives'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['DK_PL']['total_nouns'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['DK_PL']['total_verbs'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['DK_PL']['total_other'] = Word::where('DK', '!=', '')->where('PL', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['DK_PL']['total_percent'] = round( $statistics_data['DK_PL']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );

		// Spanish and Polish
		$statistics_data['ES_PL']['name'] = 'ES + PL';
		$statistics_data['ES_PL']['total_all'] = Word::where('ES', '!=', '')->where('PL', '!=', '')->count();
		$statistics_data['ES_PL']['total_adjectives'] = Word::where('ES', '!=', '')->where('PL', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['ES_PL']['total_nouns'] = Word::where('ES', '!=', '')->where('PL', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['ES_PL']['total_verbs'] = Word::where('ES', '!=', '')->where('PL', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['ES_PL']['total_other'] = Word::where('ES', '!=', '')->where('PL', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['ES_PL']['total_percent'] = round( $statistics_data['ES_PL']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );

		// Danish and Spanish
		$statistics_data['DK_ES']['name'] = 'DK + ES';
		$statistics_data['DK_ES']['total_all'] = Word::where('DK', '!=', '')->where('ES', '!=', '')->count();
		$statistics_data['DK_ES']['total_adjectives'] = Word::where('DK', '!=', '')->where('ES', '!=', '')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['DK_ES']['total_nouns'] = Word::where('DK', '!=', '')->where('ES', '!=', '')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['DK_ES']['total_verbs'] = Word::where('DK', '!=', '')->where('ES', '!=', '')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['DK_ES']['total_other'] = Word::where('DK', '!=', '')->where('ES', '!=', '')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['DK_ES']['total_percent'] = round( $statistics_data['DK_ES']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );


		// Only a specific language

		// Only Danish
		$statistics_data['ONLY_DK']['name'] = 'Only DK';
		$statistics_data['ONLY_DK']['total_all'] = Word::whereNull('ES')->whereNull('PL')->count();
		$statistics_data['ONLY_DK']['total_adjectives'] = Word::whereNull('ES')->whereNull('PL')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['ONLY_DK']['total_nouns'] = Word::whereNull('ES')->whereNull('PL')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['ONLY_DK']['total_verbs'] = Word::whereNull('ES')->whereNull('PL')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['ONLY_DK']['total_other'] = Word::whereNull('ES')->whereNull('PL')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['ONLY_DK']['total_percent'] = round( $statistics_data['ONLY_DK']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );

		// Only Spanish
		$statistics_data['ONLY_ES']['name'] = 'Only ES';
		$statistics_data['ONLY_ES']['total_all'] = Word::whereNull('DK')->whereNull('PL')->count();
		$statistics_data['ONLY_ES']['total_adjectives'] = Word::whereNull('DK')->whereNull('PL')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['ONLY_ES']['total_nouns'] = Word::whereNull('DK')->whereNull('PL')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['ONLY_ES']['total_verbs'] = Word::whereNull('DK')->whereNull('PL')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['ONLY_ES']['total_other'] = Word::whereNull('DK')->whereNull('PL')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['ONLY_ES']['total_percent'] = round( $statistics_data['ONLY_ES']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );

		// Only Polish
		$statistics_data['ONLY_PL']['name'] = 'Only PL';
		$statistics_data['ONLY_PL']['total_all'] = Word::whereNull('DK')->whereNull('ES')->count();
		$statistics_data['ONLY_PL']['total_adjectives'] = Word::whereNull('DK')->whereNull('ES')->where('type', '>', 99)->where('type', '<', 200)->count();
		$statistics_data['ONLY_PL']['total_nouns'] = Word::whereNull('DK')->whereNull('ES')->where('type', '>', 199)->where('type', '<', 300)->count();
		$statistics_data['ONLY_PL']['total_verbs'] = Word::whereNull('DK')->whereNull('ES')->where('type', '>', 299)->where('type', '<', 400)->count();
		$statistics_data['ONLY_PL']['total_other'] = Word::whereNull('DK')->whereNull('ES')->where('type', '>', 399)->where('type', '<', 999)->count();
		$statistics_data['ONLY_PL']['total_percent'] = round( $statistics_data['ONLY_PL']['total_all'] / $statistics_data['total']['total_all'] * 100, 2 );


		// Recently added words count
		$days = 6;
		$recent_words_data = [];
		foreach ($this->languages as $language) 
		{
			for ($day = $days; $day >= 0; $day--) 
			{
				$date = date('Y-m-d', strtotime('-'.$day.' day', time()));
				$wordcount = Word::where($language, '!=', '')->where('TS'.$language, '=', $date)->count();
				$recent_words_data[$language][$date] = $wordcount;
			}
		}

		return view('words.statistics', compact('statistics_data', 'recent_words_data'));
	}
}
