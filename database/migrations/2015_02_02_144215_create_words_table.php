<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('words', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('word_language_id')->unsigned()->index();
			$table->foreign('word_language_id')->references('id')->on('word_languages');
			// $table->integer('word_type_id')->unsigned();
			// $table->foreign('word_type_id')->references('id')->on('word_types');
			$table->char('text', 255);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('words');
	}

}
