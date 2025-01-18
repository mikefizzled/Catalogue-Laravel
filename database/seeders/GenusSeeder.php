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
                'family_id' => 1,
                'genus_name' => 'Alopochen',
                'slug' => 'alopochen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 1,
                'genus_name' => 'Branta',
                'slug' => 'branta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 1,
                'genus_name' => 'Cygnus',
                'slug' => 'cygnus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 1,
                'genus_name' => 'Anas',
                'slug' => 'anas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 1,
                'genus_name' => 'Aix',
                'slug' => 'aix',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 2,
                'genus_name' => 'Apus',
                'slug' => 'apus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 3,
                'genus_name' => 'Chroicocephalus',
                'slug' => 'chroicocephalus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 3,
                'genus_name' => 'Larus',
                'slug' => 'larus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 4,
                'genus_name' => 'Calidris',
                'slug' => 'calidris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 4,
                'genus_name' => 'Arenaria',
                'slug' => 'arenaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 5,
                'genus_name' => 'Haematopus',
                'slug' => 'haematopus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 6,
                'genus_name' => 'Charadrius',
                'slug' => 'charadrius',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 7,
                'genus_name' => 'Streptopelia',
                'slug' => 'Streptopelia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 7,
                'genus_name' => 'Columba',
                'slug' => 'columba',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 8,
                'genus_name' => 'Fulica',
                'slug' => 'fulica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 8,
                'genus_name' => 'Gallinula',
                'slug' => 'gallinula',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 9,
                'genus_name' => 'Pica',
                'slug' => 'pica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 9,
                'genus_name' => 'Coloeus',
                'slug' => 'coloeus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 9,
                'genus_name' => 'Garrulus',
                'slug' => 'garrulus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 9,
                'genus_name' => 'Corvus',
                'slug' => 'corvus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 10,
                'genus_name' => 'Passer',
                'slug' => 'passer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 11,
                'genus_name' => 'Sturnus',
                'slug' => 'sturnus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 12,
                'genus_name' => 'Carduelis',
                'slug' => 'carduelis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 13,
                'genus_name' => 'Turdus',
                'slug' => 'turdus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 14,
                'genus_name' => 'Erithacus',
                'slug' => 'erithacus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 15,
                'genus_name' => 'Sylvia',
                'slug' => 'sylvia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 16,
                'genus_name' => 'Cyanistes',
                'slug' => 'cyanistes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 16,
                'genus_name' => 'Parus',
                'slug' => 'parus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 17,
                'genus_name' => 'Phylloscopus',
                'slug' => 'phylloscopus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 18,
                'genus_name' => 'Certhia',
                'slug' => 'certhia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 19,
                'genus_name' => 'Cinclus',
                'slug' => 'Cinclus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 20,
                'genus_name' => 'Troglodytes',
                'slug' => 'troglodytes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 21,
                'genus_name' => 'Motacilla',
                'slug' => 'motacilla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 22,
                'genus_name' => 'Prunella',
                'slug' => 'prunella',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 23,
                'genus_name' => 'Aegithalos',
                'slug' => 'aegithalos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 24,
                'genus_name' => 'Ardea',
                'slug' => 'ardea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 25,
                'genus_name' => 'Phalacrocorax',
                'slug' => 'phalacrocorax',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'family_id' => 26,
                'genus_name' => 'Morus',
                'slug' => 'morus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
