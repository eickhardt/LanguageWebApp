<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Session;
use Auth;

class UpdateWordRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$user = Auth::user();

		$allowed_users = ['Daniel Eickhardt', 'Gabrielle Tranchet'];

		if (in_array($user->name, $allowed_users))
		{
			return true;
		}
		return false;
	}

	/**
	 * Respond accordingly if the user is not authorized.
	 */
	public function forbiddenResponse()
	{
		Session::flash('error', "You don't have permission to do that.");
		return $this->redirector->back();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'text' => 'required',
			'word_language_id' => 'required|integer|exists:word_languages,id',
		];
	}

	/**
	 * Get the sanitized input for the request.
	 *
	 * @return array
	 */
	public function sanitize()
	{
		return $this->all();
	}

}
