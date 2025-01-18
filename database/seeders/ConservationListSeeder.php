<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConservationListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conservation_lists')->insert([
            [
                'short_name' =>  'BoCC1',
                'year' => 1996,
                'full_name' => 'Bird species of conservation concern in the United Kingdom, Channel Islands and Isle of Man: revising the Red Data list',
                'filename' => null,
                'authors' => 'Gibbons, D., Avery, M., Baillie, S., Gregory, R.D., Kirby, J., Porter, R., Tucker, G. & Williams, G.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'short_name' => 'BoCC2',
                'year' => 2002,
                'full_name' => 'The population status of birds in the United Kingdom,Channel Islands and Isle of Man: an analysis of conservation concern 2002-2007',
                'filename' => 'Gregoryetal.2002-BOCCII-BritishBirds.pdf',
                'authors' => 'Richard D.Gregory,Nicholas I.Wilkinson, David G.Noble,James A.Robinson, Andrew F.Brown,Julian Hughes,Deborah Procter, David W.Gibbons and Colin A.Galbraith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'short_name' => 'BoCC3',
                'year' => 2008,
                'full_name' => 'Birds of Conservation Concern 3 The population status of birds in the United Kingdom, Channel Islands and Isle of Man',
                'filename' => 'UK-Birds-of-Conservation-Concern-3.pdf',
                'authors' => 'Mark A. Eaton, Andy F. Brown, David G. Noble, Andy J. Musgrove, Richard D. Hearn, Nicholas J. Aebischer, David W. Gibbons, Andy Evans and Richard D. Gregory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'short_name' => 'BoCC4',
                'year' => 2015,
                'full_name' => 'Birds of Conservation Concern 4: the population status of birds in the UK, Channel Islands and Isle of Man',
                'filename' => 'Birds_of_Conservation_Concern_4_the_population_status_of_birds_in_the_UK_Channel_Islands_and_Isle_of_Man.pdf',
                'authors' => 'Mark Eaton, Nicholas Aebischer, Andy Brown, Richard Hearn, Leigh Lock, Andy Musgrove, David Noble, David Stroud and Richard Gregory',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ,
            [
                'short_name' => 'BoCC5',
                'year' => 2021,
                'full_name' => 'The status of our bird populations: the fifth Birds of Conservation Concern in the United Kingdom, Channel Islands and Isle of Man and second IUCN Red List assessment of extinction risk for Great Britain',
                'filename' => 'BB_Dec21-BoCC5-IUCN2.pdf',
                'authors' => 'Andrew Stanbury, Mark Eaton, Nicholas Aebischer, Dawn Balmer, Andy Brown, Andy Douse, Patrick Lindley, Neil McCulloch, David Noble and Ilka Win',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ,            [
                'short_name' => 'BoCC5a',
                'year' => 2024,
                'full_name' => 'The status of the UK\'s breeding seabirds: an addendum to the fifth Birds of Conservation Concern in the United Kingdom, Channel Islands and Isle of Man and second IUCN Red List assessment of extinction risk for Great Britain',
                'filename' => 'Seabird-BoCC_British-Birds_September-2024.pdf',
                'authors' =>  'Andrew J. Stanbury, Fiona Burns, Nicholas J. Aebischer, Helen Baker, Dawn E. Balmer, Andy Brown, Tim Dunn, Patrick Lindley, Matthew Murphy, David G. Noble, Ronan Owens and Lucy Quinn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
