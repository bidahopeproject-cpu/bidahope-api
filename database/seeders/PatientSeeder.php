<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'id' => '1',
                'patient_code' => 'PAT000000000001',
                'first_name' => 'Juan',
                'middle_name' => 'Santos',
                'last_name' => 'Dela Cruz',
                'suffix' => 'Jr.',
                'gender' => 'Male',
                'birth_date' => '1990-04-12',
                'blood_type' => 'O+',
                'medical_condition' => 'Hypertension',
                'region' => [
                    "code" => "030000000",
                    "name" => "Central Luzon",
                    "regionName" => "Region III",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0300000000"
                ], 
                'province' => [
                    "code" => "031400000",
                    "name" => "Bulacan",
                    "regionCode" => "030000000",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0301400000"
                ],
                'city' =>  [
                    "code" => "031414000",
                    "name" => "Obando",
                    "oldName" => "",
                    "isCapital" => false,
                    "isCity" => false,
                    "isMunicipality" => true,
                    "provinceCode" => "031400000",
                    "districtCode" => false,
                    "regionCode" => "030000000",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0301414000"
                ],
                'barangay' => [
                    "code" => "031414007",
                    "name" => "Pag-asa (Pob.)",
                    "oldName" => "",
                    "subMunicipalityCode" => false,
                    "cityCode" => false,
                    "municipalityCode" => "031414000",
                    "districtCode" => false,
                    "provinceCode" => "031400000",
                    "regionCode" => "030000000",
                ],
                'contact_number' => '09123456789',
                'email' => 'juan@email.com',
                'patient_role' => 'recipient',
                'status' => 'alive',
                'date_of_death' => null,
                'death_cause' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'patient_code' => 'PAT000000000002',
                'first_name' => 'Benjamin',
                'middle_name' => 'Coles',
                'last_name' => 'Perez',
                'suffix' => '',
                'gender' => 'Male',
                'birth_date' => '1998-01-28',
                'blood_type' => 'B+',
                'medical_condition' => 'Hypoglycemia',
                'region' => [
                    "code" => "030000000",
                    "name" => "Central Luzon",
                    "regionName" => "Region III",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0300000000"
                ], 
                'province' => [
                    "code" => "031400000",
                    "name" => "Bulacan",
                    "regionCode" => "030000000",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0301400000"
                ],
                'city' =>  [
                    "code" => "031414000",
                    "name" => "Obando",
                    "oldName" => "",
                    "isCapital" => false,
                    "isCity" => false,
                    "isMunicipality" => true,
                    "provinceCode" => "031400000",
                    "districtCode" => false,
                    "regionCode" => "030000000",
                    "islandGroupCode" => "luzon",
                    "psgc10DigitCode" => "0301414000"
                ],
                'barangay' => [
                    "code" => "031414007",
                    "name" => "Pag-asa (Pob.)",
                    "oldName" => "",
                    "subMunicipalityCode" => false,
                    "cityCode" => false,
                    "municipalityCode" => "031414000",
                    "districtCode" => false,
                    "provinceCode" => "031400000",
                    "regionCode" => "030000000",
                ],
                'contact_number' => '09550437955',
                'email' => 'benjieperez28@email.com',
                'patient_role' => 'donor',
                'status' => 'alive',
                'date_of_death' => null,
                'death_cause' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Transform arrays to JSON strings
        $patients = array_map(function ($patient) {
            $patient['region'] = json_encode($patient['region']);
            $patient['province'] = json_encode($patient['province']);
            $patient['city'] = json_encode($patient['city']);
            $patient['barangay'] = json_encode($patient['barangay']);
            return $patient;
        }, $patients);

        // Insert the data
        DB::table('patients')->insert($patients);
    }
}