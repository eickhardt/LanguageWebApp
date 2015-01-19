<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();
    
    User::create(array(
      'email' => 'ddeickhardt@gmail.com',
      'password' => Hash::make( 'Daniel6636' ),
      'name' => 'Daniel Eickhardt',
      'created_at' => time(),
      'updated_at' => time()
    ));

    User::create(array(
      'email' => 'g.tranchet@gmail.com',
      'password' => Hash::make( 'MyLittleWoman' ),
      'name' => 'Gabrielle Tranchet',
      'created_at' => time(),
      'updated_at' => time()
    ));

    User::create(array(
      'email' => 'dummy@mail.com',
      'password' => Hash::make( 'dummy' ),
      'name' => 'Dummy User',
      'created_at' => time(),
      'updated_at' => time()
    ));
  }

}