<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Word;
use Session;
use DB;
use Input;

class WordsController extends Controller {

	/**
	 * @var Word
	 */
	private $word;

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
	 */
	public function update(Word $word)
	{
		$word = Word::where('id', $word->id)->first();

		// If a word is emtpy in DK PL or ES and is now being set, also set corresponding date
		$fields = ['DK', 'ES', 'PL'];

		foreach ($fields as $field) 
		{
			if ($word->$field == NULL)
			{
				if (\Request::get($field))
				{
					$word->$field = \Request::get($field);
					$timefield = 'TS'.$field;
					$word->$timefield = date('Y-m-d');
				}
			}
			else
			{
				$word->$field = \Request::get($field);
			}
		}

		// Set the rest of the fields
		$word->TSDK = \Request::get('TSDK');
		$word->TSPL = \Request::get('TSPL');
		$word->TSES = \Request::get('TSES');
		$word->FR = \Request::get('FR');
		$word->EN = \Request::get('EN');
		$word->type = \Request::get('type');
		$word->update();

		Session::flash('success', "The word '".$word->FR."' was updated.");
		return redirect(route('word_edit_path', $word->id));
	}

	/**
	 * Show form for creating a new word.
	 */
	public function create()
	{
		return view('words.create');
	}

	/**
	 * Store a new word.
	 */
	public function store()
	{
		// TODO: Validate.

		// Create word
		$word = new Word;
		$word->type = \Request::get('type');
		$word->FR = \Request::get('FR');
		$word->EN = \Request::get('EN');
		
		$word->DK = \Request::get('DK');
		$word->ES = \Request::get('ES');
		$word->PL = \Request::get('PL');

		$fields = ['DK', 'ES', 'PL'];
		foreach ($fields as $field) 
		{
			if (\Request::get($field))
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
	 */
	public function destroy(Word $word)
	{
		$oldword = $word->FR;
		$word->delete();

		Session::flash('success', "The word '" .$oldword. "' was deleted.");
		return redirect('words');
	}

	/**
	 * Search for a word.
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
	 */
	public function random()
	{
		$words = Word::orderByRaw("RAND()")->take(1)->get();

		$list_type = 'Random word';

		return view('words.list', compact('words', 'list_type'));
	}
}
