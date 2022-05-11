<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => 'Eldrin',
          'email'=> 'eldrin.bradecina@gmail.com',
          'username'=>'adminK',
          'password'=> Hash::make('12345678'),
          'role_id'=> '1'
        ]);

        DB::table('users')->insert([
            'name' => 'Ryan',
            'email'=> 'rbok12@gmail.com',
            'username'=>'adminR',
            'password'=> Hash::make('12345678'),
            'role_id'=> '1'
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email'=> 'webdev@inglewoodfarms.com',
            'username'=>'user',
            'password'=> Hash::make('12345678'),
            'role_id'=> '2'
        ]);
      //
    }
}
