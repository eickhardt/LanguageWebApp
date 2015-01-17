<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Static guest routes
 */
get('/', 'WelcomeController@index');

get('home', 'HomeController@index');

// TODO: Fix proper registration
get('auth/register', function() {
	return redirect('home');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/**
 * Routes that require login
 */

$router->bind('words', function($id) 
{
	return App\Word::where('ID', $id)->first();
});

$router->resource('words', 'WordsController', [
	'names' => [
		'index' => 'words_path',
		'show' => 'word_path',
		'destroy' => 'word_delete_path',
		'create' => 'word_create_path',
		'update' => 'word_update_path',
		'edit' => 'word_edit_path',
		'store' => 'word_store_path',
	]
]);

// get('words', 'WordsController@index');
// get('words/{word}', 'WordsController@show');
// get('words/{word}/edit', 'WordsController@edit');
// patch('words/{word}', 'WordsController@update');
