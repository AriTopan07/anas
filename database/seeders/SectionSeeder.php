<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Master Data',
                'order' => 1,
                'icons' => 'grid-fill',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Transactions',
                'order' => 2,
                'icons' => 'grid-fill',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Stock',
                'order' => 3,
                'icons' => 'grid-fill',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Report',
                'order' => 4,
                'icons' => 'grid-fill',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Users',
                'order' => 5,
                'icons' => 'people',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Settings',
                'order' => 6,
                'icons' => 'file-earmark-bar-graph',
                'status' => 'active',
            ]);
    }
}
