<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Session;
use Auth;

class CreateMeaningRequest extends Request {

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
			'real_word_type' => 'required|integer|min:100|max:999',
			'word_type_id' => 'required|exists:word_types,id',
			'en' => 'required',
			'fr' => 'required',
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
