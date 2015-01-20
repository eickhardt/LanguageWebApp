<?php

use Illuminate\Database\Seeder;
use App\Word;

class WordTableSeeder extends Seeder {

  public function run()
  {
    DB::table('words_all')->delete();

    // LanguageLearningBackup_Test
    // $backup_path = storage_path().'/data/backups/';
    $backup_path = storage_path().'/data/';

    $files = scandir($backup_path, SCANDIR_SORT_DESCENDING);
    $newest_file = $files[0];

    $wordJson = File::get($backup_path.'LanguageLearningBackup_Test.json');

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
  }

}