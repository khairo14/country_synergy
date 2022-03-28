<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
          'password'=> '12345678',
          'role_id'=> '1'
        ]);

        DB::table('users')->insert([
            'name' => 'Ryan',
            'email'=> 'rbok12@gmail.com',
            'password'=> '12345678',
            'role_id'=> '1'
        ]);

        DB::table('users')->insert([
            'name' => 'khairo',
            'email'=> 'khairo.smile@gmail.com',
            'password'=> '12345678',
            'role_id'=> '2'
        ]);
      //
    }
}
