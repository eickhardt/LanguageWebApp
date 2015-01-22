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

$router->get('home', 
	['as' => 'home', 'uses' => 'HomeController@index']
);

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
	return App\Word::where('id', $id)->first();
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

$router->post('words/search', 
	['as' => 'word_search_path', 'uses' => 'WordsController@search']
);

$router->get('word/random', 
	['as' => 'word_random_path', 'uses' => 'WordsController@random']
);

$router->get('word/backup', 
	['as' => 'word_backup_path', 'uses' => 'WordsController@backup']
);

$router->get('word/statistics', 
	['as' => 'word_statistics_path', 'uses' => 'WordsController@statistics']
);

$router->get('word/word_of_the_day', 
	['as' => 'word_wotd_path', 'uses' => 'WordsController@wotd']
);

$router->get('user/settings', 
	['as' => 'user_settings_path', 'uses' => 'UsersController@settings']
);