<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordWotdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('word_wotds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date');
			$table->integer('word_meaning_id')->unsigned()->index();
			$table->foreign('word_meaning_id')->references('id')->on('word_meanings');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('word_wotds');
	}

}
