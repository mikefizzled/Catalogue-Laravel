<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('families')->insert([
            [
                'order_id' =>  1,
                'family_name' => 'Anatidae',
                'common_name' => 'Ducks, Geese, and Swans',
                'slug' => 'anatidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  2,
                'family_name' => 'Apodidae',
                'common_name' => 'Swifts',
                'slug' => 'apodidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  3,
                'family_name' => 'Laridae',
                'common_name' => 'Gulls and Terns',
                'slug' => 'laridae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  3,
                'family_name' => 'Scolopacidae',
                'common_name' => 'Sandpipers',
                'slug' => 'scolopacidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  3,
                'family_name' => 'Haematopodidae',
                'common_name' => 'Oystercatchers',
                'slug' => 'haematopodidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  3,
                'family_name' => 'Charadriidae',
                'common_name' => 'Plovers and Lapwings',
                'slug' => 'charadriidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  4,
                'family_name' => 'Columbidae',
                'common_name' => 'Pigeons and Doves',
                'slug' => 'columbidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  5,
                'family_name' => 'Rallidae',
                'common_name' => 'Rails',
                'slug' => 'rallidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Corvidae',
                'common_name' => 'Crows',
                'slug' => 'corvidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Passeridae',
                'common_name' => 'Old World Sparrows',
                'slug' => 'passeridae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Sturnidae',
                'common_name' => 'Starlings',
                'slug' => 'sturnidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Fringillidae',
                'common_name' => 'Finches',
                'slug' => 'fringillidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Turdidae',
                'common_name' => 'Thrushes',
                'slug' => 'turdidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Muscicapidae',
                'common_name' => 'Old World Flycatchers',
                'slug' => 'muscicapidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Sylviidae',
                'common_name' => 'Typical Warblers and Babblers',
                'slug' => 'sylviidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Paridae',
                'common_name' => 'Tits',
                'slug' => 'paridae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Phylloscopidae',
                'common_name' => 'Leaf Warblers',
                'slug' => 'phylloscopidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Certhiidae',
                'common_name' => 'Treecreepers',
                'slug' => 'certhiidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Cinclidae',
                'common_name' => 'Dippers',
                'slug' => 'cinclidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Troglodytidae',
                'common_name' => 'Wrens',
                'slug' => 'troglodytidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Motacillidae',
                'common_name' => 'Wagtails, Longclaws and Pipits',
                'slug' => 'motacillidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Prunellidae',
                'common_name' => 'Accentors',
                'slug' => 'prunellidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  6,
                'family_name' => 'Aegithalidae',
                'common_name' => 'Bushtits',
                'slug' => 'aegithalidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  7,
                'family_name' => 'Ardeidae',
                'common_name' => 'Herons, Bitterns, and Egrets',
                'slug' => 'ardeidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  8,
                'family_name' => 'Phalacrocoracidae',
                'common_name' => 'Cormorants and Shags',
                'slug' => 'phalacrocoracidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' =>  8,
                'family_name' => 'Sulidae',
                'common_name' => 'Gannets and Boobies',
                'slug' => 'sulidae',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
