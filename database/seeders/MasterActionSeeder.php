<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;


use Illuminate\Database\Seeder;

class MasterActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_actions')
            ->insert([
                [
                    'name' => 'view',
                    'description' => 'Hak untuk mengakses halaman',
                ],
                [
                    'name' => 'detail',
                    'description' => 'ombol aksi untuk melihat detail data',
                ],
                [
                    'name' => 'add',
                    'description' => 'Tombol aksi untuk menambah data',
                ],
                [
                    'name' => 'edit',
                    'description' => 'Tombol aksi untuk mengedit data',
                ],
                [
                    'name' => 'delete',
                    'description' => 'Tombol aksi untuk verifikasi data',
                ],
                [
                    'name' => 'verif',
                    'description' => '-',
                ],
                [
                    'name' => 'export',
                    'description' => 'Tombol aksi untuk export data',
                ],
            ]);
    }
}
