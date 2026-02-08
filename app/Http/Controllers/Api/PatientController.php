<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private function patientRules(): array
    {
        return [
            'first_name'        => 'required|string|max:100',
            'middle_name'       => 'nullable|string|max:100',
            'last_name'         => 'required|string|max:100',
            'suffix'            => 'nullable|string|max:10',
            'gender'            => 'required|in:male,female,other',
            'birth_date'        => 'required|date',
            'blood_type'        => 'nullable|string|max:5',
            'medical_condition' => 'nullable|string',
            'region'            => 'nullable|array',
            'province'          => 'nullable|array',
            'city'              => 'nullable|array',
            'barangay'          => 'nullable|array',
            'contact_number'    => 'nullable|string|max:20',
            'email'             => 'nullable|email',
            'patient_role'      => 'required|in:donor,recipient',
            'status'            => 'required|in:alive,deceased',
            'date_of_death'     => 'nullable|date|required_if:status,deceased',
            'death_cause'       => 'nullable|string|required_if:status,deceased',

        ];
    }

    // GET ALL PATIENTS
    public function index()
    {
        return Patient::latest()->get();
    }

    // STORE NEW PATIENT
    public function store(Request $request)
    {
        $validated = $request->validate($this->patientRules());

        // Generate patient code
        $latestId = Patient::max('id') ?? 0;
        $patientCode = 'PAT' . str_pad($latestId + 1, 12, '0', STR_PAD_LEFT);

        $patient = Patient::create([
            'patient_code' => $patientCode,
            'first_name'        => $validated['first_name'],
            'middle_name'       => $validated['middle_name'] ?? null,
            'last_name'         => $validated['last_name'],
            'suffix'            => $validated['suffix'] ?? null,
            'gender'            => $validated['gender'],
            'birth_date'        => $validated['birth_date'],
            'blood_type'        => $validated['blood_type'] ?? null,
            'medical_condition' => $validated['medical_condition'] ?? null,
            'region'            => $validated['region'] ?? null,
            'province'          => $validated['province'] ?? null, // Added province
            'city'              => $validated['city'] ?? null,
            'barangay'          => $validated['barangay'] ?? null,
            'contact_number'    => $validated['contact_number'] ?? null,
            'email'             => $validated['email'] ?? null,
            'patient_role'      => $validated['patient_role'],
            'status'            => $validated['status'] ?? "alive",
            'date_of_death'     => $validated['date_of_death'] ?? null,
            'death_cause'       => $validated['death_cause'] ?? null,
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'data'    => $patient,
        ], 201);
    }

    // SHOW SINGLE PATIENT
    public function show($patient_code)
    {   
        $patient = Patient::where('patient_code', $patient_code)
        ->leftJoin('patient_waitlists', 'patients.id', '=', 'patient_waitlists.patient_id')
        ->select('patients.*', 'patient_waitlists.id as patient_waitlists_id')
        ->first();
        return response()->json([
            'message' => 'ok',
            'data' => $patient
        ]);
    }

    // UPDATE PATIENT
    public function update(Request $request, $patient_code)
    {
        $patient = Patient::where('patient_code', $patient_code)->firstOrFail();

        $validated = $request->validate($this->patientRules());

        $patient->update($validated);

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $patient->fresh()
        ]);
    }



    // DELETE PATIENT
    public function destroy($patient_code)
    {
        Patient::where('patient_code', $patient_code)->delete();

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }
}