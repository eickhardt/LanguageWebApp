<?php

use Illuminate\Database\Seeder;
use App\Word;

class WordTableSeeder extends Seeder {

  public function run()
  {
    DB::table('words_all')->delete();

    $backup_path = storage_path().'/data/backups/';

    $files = scandir($backup_path, SCANDIR_SORT_DESCENDING);
    $newest_file = $files[0];

    $wordJson = File::get($backup_path.$newest_file);

    $word = json_decode($wordJson);
    foreach ($word as $object) {
      Word::create(array(
        'type' => $object->type,
        'DK' => $object->DK,
        'EN' => $object->EN,
        'FR' => $object->FR,
        'ES' => $object->ES,
        'PL' => $object->PL,
        'TSDK' => $object->TSDK,
        'TSES' => $object->TSES,
        'TSPL' => $object->TSPL,
      ));
    }

    DB::table('word_of_day')->delete();

    Artisan::call('setwordofday');
  }

}