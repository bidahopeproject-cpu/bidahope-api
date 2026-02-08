<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organ;

class OrganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $organs = [
            ['name' => 'Kidney'],
            ['name' => 'Liver'],
            ['name' => 'Heart'],
            ['name' => 'Lungs'],
            ['name' => 'Pancreas'],
            ['name' => 'Cornea'],
        ];

        foreach ($organs as $organ) {
            Organ::create($organ);
        }
    }
}
