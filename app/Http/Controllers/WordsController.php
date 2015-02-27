<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWordRequest;
use App\Http\Requests\UpdateWordRequest;

// use App\Word;
use App\WordN;
use App\WordType;
use App\WordWotd;
use App\WordMeaning;
use App\WordLanguage;

use DB;
use Log;
use Auth;
use File;
use Input;
use Session;
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
	public function __construct(WordN $word)
	{
		$this->middleware('auth');

		$this->word = $word;
	}


	/**
	 * Show an individual word.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function show($word)
	{
		$words[] = $word;
		return view('lists.words', compact('words'));
	}


	/**
	 * Show the edit page for a specific word.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function edit($word)
	{
		$languages = WordLanguage::asKeyValuePairs();

		return view('words.edit', compact('word', 'languages'));
	}


	/**
	 * Update a word.
	 *
	 * @param CreateWordRequest $request
	 * @param Word $word
	 * @return mixed
	 */
	public function update(UpdateWordRequest $request, WordN $word)
	{
		$word->text = $request->get('text');
		$word->word_language_id = $request->get('word_language_id');
		$word->save();

		// dd("The word '".$word->text."' was updated.");

		Session::flash('success', "The word '".$word->text."' was updated.");
		return redirect()->route('word_edit_path', $word->id);
	}


	/**
	 * Show form for creating a new word.
	 *
	 * @return mixed
	 */
	public function create()
	{
		$languages = WordLanguage::asKeyValuePairs();

		if (Input::has('meaning_id'))
		{
			$meaning = WordMeaning::with('type')->with('words')->find(Input::get('meaning_id'));
			return view('words.create', compact('word', 'languages', 'meaning'));
		}

		return view('words.create', compact('word', 'languages'));
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
		$word = WordN::create([
			'word_language_id' => $request->get('word_language_id'), 
			'text' => $request->get('text')
		]);
		$word->meanings()->attach($request->get('meaning_id'));

		Session::flash('success', "A new word '".$word->text."' was created.");
		return redirect()->route('word_edit_path', $word->id);
	}


	/**
	 * Delete a word
	 *
	 * @param Word $word
	 * @return mixed
	 */
	public function destroy(WordN $word)
	{
		$user = Auth::user();

		$allowed_users = ['Daniel Eickhardt', 'Gabrielle Tranchet'];

		if (!in_array($user->name, $allowed_users))
		{
			Session::flash('error', "You don't have permission to do that.");
			return redirect()->back();
		}

		$oldword = $word->text;

		// Soft delete the words relations
		DB::table('word_word_meaning')
			->where('word_id', $word->id)
			->update(array('deleted_at' => DB::raw('NOW()')));

		// Soft delete the word
		$word->delete();

		Session::flash('success', "The word '" .$oldword. "' was deleted.");
		return redirect()->route('search_path');
	}


	/**
	 * Search for a word.
	 *
	 * @param String $value  The value to search for.
	 * @return mixed
	 */
	public function search()
	{
		if (Input::has('search_term'))
		{
			$search_term = Input::get('search_term');
			$search_term = "%{$search_term}%";
			$words = WordN::where('text', 'LIKE', $search_term);

			if (Input::has('options') && Input::get('options'))
			{
				$options_obj = json_decode(Input::get('options'));

				if ($options_obj->types)
				{
					$words = $words->whereHas('meanings', function($q) use($options_obj)
					{
						$q->whereNotIn('word_type_id', $options_obj->types);
					});
				}
				
				if ($options_obj->languages)
				{
					$words = $words->whereNotIn('word_language_id', $options_obj->languages);
				}
			}

			$words = $words->get();

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
		$list_type = 'Random';
		$words[] = WordN::random();
		$languages = WordLanguage::all();

		return view('lists.words', compact('words', 'list_type', 'languages'));
	}


	/**
	 * Show a random word.
	 *
	 * @return mixed
	 */
	public function showTrashed()
	{
		$list_type = 'Trashed';
		$languages = WordLanguage::all();
		$words = WordN::onlyTrashed()->get();

		return view('lists.words', compact('words', 'list_type', 'languages'));
	}


	/**
	 * Restore a deleted word.
	 *
	 * @return mixed
	 */
	public function restore($id)
	{
		$word = WordN::withTrashed()->find($id);
		$word->restore();

		DB::table('word_word_meaning')
			->where('word_id', $id)
			->update(array('deleted_at' => NULL));

		Session::flash('success', "The word '" .$word->text. "' was restored.");
		return redirect()->route('words_trashed_path');
	}
}
