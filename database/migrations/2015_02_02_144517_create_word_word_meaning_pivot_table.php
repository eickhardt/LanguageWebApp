<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordWordMeaningPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('word_word_meaning', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('word_id')->unsigned()->index();
			$table->integer('word_meaning_id')->unsigned()->index();
			// $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
			// $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
			// $table->foreign('word_meaning_id')->references('id')->on('word_meanings')->onDelete('cascade');
			// $table->foreign('word_meaning_id')->references('id')->on('word_meanings')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('word_word_meaning');
	}

}
