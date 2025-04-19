<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = [
            ['name' => 'Kanto'],
            ['name' => 'Johto',],
            ['name' => 'Hoenn'],
            ['name' => 'Sinnoh'],
            ['name' => 'Unova'],
            ['name' => 'Kalos'],
            ['name' => 'Alola'],
            ['name' => 'Galar' ],
            ['name' => 'Paldea'],
        ];
    
        foreach ($generations as $gen) {
            DB::table('generations')->updateOrInsert(
                ['name' => $gen['name']], 
                $gen
            );
        }
    }
}
