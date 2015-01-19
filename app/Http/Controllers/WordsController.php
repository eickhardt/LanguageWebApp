<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Controllers\Controller;
use App\Word;
use Session;
use File;
use DB;
use Input;
use Response;

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
		$word->TSDK = $request->get('TSDK');
		$word->TSPL = $request->get('TSPL');
		$word->TSES = $request->get('TSES');

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
				$word->$field = $request->get($field);
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
		$word->DK = $request->get('DK');
		$word->ES = $request->get('ES');
		$word->PL = $request->get('PL');

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
		$oldword = $word->FR;
		$word->delete();

		Session::flash('success', "The word '" .$oldword. "' was deleted.");
		return redirect()->route('words_path');
	}


	/**
	 * Search for a word.
	 *
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
}
