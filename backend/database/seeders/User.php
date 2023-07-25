<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  date('Y-m-d H:i:s');

        DB::table('users')->insert([
            [
                'name' => 'Marcos Lopes',
                'password' => Hash::make('1234'),
                'email' => 'marcoslopesg7@gmail.com',
                'created_at' =>  $data,
                'updated_at' =>  $data
            ]
        ]);
    }
}
