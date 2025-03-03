<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'label_name' => 'Action',
                'value' => 'Action',
            ],
            [
                'label_name' => 'Horror',
                'value' => 'Horror',
            ],
            [
                'label_name' => 'Romantic',
                'value' => 'Romantic',
            ],
            [
                'label_name' => 'Thriller',
                'value' => 'Thriller',
            ],
        ];
        DB::table('genres')->insert($data);
    }
}
