<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserRole;

class UserTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->delete();
    DB::table('user_roles')->delete();

    $admin_role = UserRole::create(['name' => 'Administrator']);

    UserRole::create(['name' => 'Manager']);
    UserRole::create(['name' => 'Editor']);
    UserRole::create(['name' => 'Author']);
    UserRole::create(['name' => 'Contributor']);
    UserRole::create(['name' => 'Moderator']);
    UserRole::create(['name' => 'Member']);
    UserRole::create(['name' => 'Subscriber']);
    $std_role = UserRole::create(['name' => 'User']);
    
    $user = User::create(array(
      'email' => 'ddeickhardt@gmail.com',
      'password' => Hash::make( 'Daniel6636' ),
      'name' => 'Daniel Eickhardt',
      'created_at' => time(),
      'updated_at' => time()
    ));
    $user->roles()->attach($admin_role->id);

    $user = User::create(array(
      'email' => 'g.tranchet@gmail.com',
      'password' => Hash::make( 'MyLittleWoman' ),
      'name' => 'Gabrielle Tranchet',
      'created_at' => time(),
      'updated_at' => time()
    ));
    $user->roles()->attach($admin_role->id);

    User::create(array(
      'email' => 'dummy@mail.com',
      'password' => Hash::make( 'dummy' ),
      'name' => 'Dummy User',
      'created_at' => time(),
      'updated_at' => time()
    ));
    $user->roles()->attach($std_role->id);
  }

}