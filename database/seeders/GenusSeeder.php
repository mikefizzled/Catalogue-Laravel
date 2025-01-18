<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genera')->insert([
            [
                'order_id' =>  1,
                'family_name' => 'Anatidae',
                'common_name' => 'Ducks, Geese, and Swans',
                'slug' => 'anatidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
