<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => 'Admininstrator',
                'description' => 'Hak Akses untuk Admin',
            ],
            [
                'name' => 'User',
                'description' => 'Hak Akses untuk user',
            ],
        ]);
    }
}
