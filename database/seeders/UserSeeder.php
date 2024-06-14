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
            [
                'name' => 'Admininstrator',
                'username' => 'admin',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
        ]);
    }
}
