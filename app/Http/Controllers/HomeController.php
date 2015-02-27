<?php namespace App\Http\Controllers;

use App\WordN;
use App\WordLanguage;
use App\WordType;
use App\WordWotd;

class HomeController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(WordN $word, WordWotd $wotd)
	{
		$wordcount = $word->count();
		$wotd = $wotd->getCurrent();
		
		return view('home', compact('wordcount', 'wotd'));
	}


	/**
	 * Show the search page.
	 *
	 * @param Word $word
	 * @return View
	 */
	public function showSearch()
	{
		$languages = WordLanguage::all();
		$types = WordType::all();

		return view('search.index', compact('languages', 'types'));
	}

}
