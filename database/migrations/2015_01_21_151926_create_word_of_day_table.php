<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordOfDayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('word_of_day', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('word_id')->unsigned();
			$table->foreign('word_id')->references('id')->on('words_all');
			$table->date('date');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('word_of_day');
	}

}
