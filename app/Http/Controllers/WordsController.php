<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Word;
use Session;

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
		$words = $this->word->get();

		return view('words.index', compact('words'));
	}

	/**
	 * Show an individual word.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function show(Word $word)
	{
		return view('words.show', compact('word'));
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
		// If a word is emtpy in DK PL or ES and is now being set, also set corresponding date
		$fields = ['DK', 'ES', 'PL'];

		$word = Word::where('id', $word->id)->first();

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
		$word->FR = \Request::get('FR');
		$word->EN = \Request::get('EN');
		$word->type = \Request::get('type');
		$word->update();

		// dd($word);
		Session::flash('success', "The word '".$word->FR."' was updated.");
		return redirect(route('word_path', $word->id));
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
		return redirect('words/'.$word->id);
	}

	/**
	 * Delete a word
	 */
	public function destroy(Word $word)
	{
		$oldword = $word->FR;
		$word->delete();

		Session::flash('success', 'The word ' .$oldword. ' was deleted.');
		return redirect('words');
	}

}
