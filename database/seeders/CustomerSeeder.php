<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customers')->insert([
            'name' => 'PlantNet',
            'street'=> 'Aus',
            'contact_person'=> 'Greg',
            'city'=> 'Aus',
            'state' =>'Aus',
            'phone'=>'0000',
            'gtin_start'=>2,
            'gtin_end'=>14,
        ]);
        DB::table('customers')->insert([
            'name' => 'Country Synergy',
            'street'=> 'PH',
            'contact_person'=> 'Ry',
            'city'=> 'ph',
            'state' =>'ph',
            'phone'=>'0001',
            'gtin_start'=>2,
            'gtin_end'=>14,
        ]);

    }
}
