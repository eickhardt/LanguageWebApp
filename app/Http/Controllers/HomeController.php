<?php namespace App\Http\Controllers;

use App\Word;
use App\WordN;
use App\WordWotd;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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

}
