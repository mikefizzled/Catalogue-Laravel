<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'order_name' =>  'Anseriformes',
                'slug' => 'anseriformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Apodiformes',
                'slug' => 'apodiformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Charadriiformes',
                'slug' => 'charadriiformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Columbiformes',
                'slug' => 'columbiformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Gruiformes',
                'slug' => 'gruiformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Passeriformes',
                'slug' => 'passeriformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Pelecaniformes',
                'slug' => 'pelecaniformes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_name' =>  'Suliformes',
                'slug' => 'suliformes',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
