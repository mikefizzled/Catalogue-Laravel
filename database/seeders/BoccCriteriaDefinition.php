<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BoccCriteriaDefinition extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bocc_criteria_definitions')->insert([
            ['code' => 'IUCN', 'description' => 'Globally threatened'],
            ['code' => 'HD', 'description' => 'Historical decline in the breeding population'],
            ['code' => 'BDp', 'description' => 'Severe breeding population decline over 25 years'],
            ['code' => 'WDp', 'description' => 'Severe non-breeding population decline over 25 years'],
            ['code' => 'BDr', 'description' => 'Severe breeding range decline over 25 years'],
            ['code' => 'WDr', 'description' => 'Severe non-breeding range decline over 25 years'],
            ['code' => 'ERLOB', 'description' => 'Threatened in Europe'],
            ['code' => 'HDrec', 'description' => 'Historical decline – recovery'],
            ['code' => 'BDMp', 'description' => 'Moderate breeding population decline over 25 years'],
            ['code' => 'WDMp', 'description' => 'Moderate non-breeding population decline over 25 years'],
            ['code' => 'BDMr', 'description' => 'Moderate breeding range decline over 25 years'],
            ['code' => 'WDMr', 'description' => 'Moderate non-breeding range decline over 25 years'],
            ['code' => 'BR', 'description' => 'Breeding rarity'],
            ['code' => 'WR', 'description' => 'Non-breeding rarity'],
            ['code' => 'BL', 'description' => 'Breeding localization'],
            ['code' => 'WL', 'description' => 'Non-breeding localization'],
            ['code' => 'BI', 'description' => 'Breeding international importance'],
            ['code' => 'WI', 'description' => 'Non-breeding international importance'],
        ]);
        
    }
}
