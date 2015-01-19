<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsAllTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('words_all', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type');
			$table->char('DK', 255)->nullable();
			$table->char('EN', 255);
			$table->char('FR', 255);
			$table->char('PL', 255)->nullable();
			$table->char('ES', 255)->nullable();
			$table->date('TSPL')->nullable();
			$table->date('TSDK')->nullable();
			$table->date('TSES')->nullable();
		});

		// $path = storage_path();
		// $mysqlImportFilename = $path.'/data/words.sql';
		// $mysqlDatabaseName = getenv('DB_DATABASE');
		// $mysqlUserName = getenv('DB_USERNAME');
		// $mysqlPassword = getenv('DB_PASSWORD');
		// $mysqlHostName = getenv('DB_HOST');

		// $command = 'mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		// $output = [];
		// exec($command, $output, $worked);
		// switch($worked) 
		// {
		//     case 0:
		//         echo 'Import file ' .$mysqlImportFilename .' successfully imported to database "' .$mysqlDatabaseName . '"'."\n";
		//         break;
		//     case 1:
		//         echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values: MySQL Database Name:' .$mysqlDatabaseName .' MySQL User Name: ' .$mysqlUserName .' MySQL Password: NOTSHOWN MySQL Host Name: ' .$mysqlHostName .' MySQL Import Filename: ' .$mysqlImportFilename ."\n";
		//         break;
		// }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('words_all');
	}

}
