<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganDonationSeeder extends Seeder
{
    // php artisan db:seed --class=OrganDonationSeeder
    public function run(): void
    {
        $organs = DB::table('organs')->pluck('id')->toArray();

        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        $data = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            // Random number of donations per day
            $donationsToday = rand(0, 4);

            for ($i = 0; $i < $donationsToday; $i++) {
                $data[] = [
                    'patient_id' => 1,
                    'organ_id' => $organs[array_rand($organs)],
                    'donation_date' => $date->format('Y-m-d'),
                    'status' => collect(['available', 'used', 'expired'])->random(),
                    'created_at' => $date->copy()->addMinutes(rand(1, 1440)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('organ_donations')->insert($data);
    }
}