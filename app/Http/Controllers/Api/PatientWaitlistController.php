<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientWaitlist;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientWaitlistController extends Controller
{
    public function index()
    {
        return PatientWaitlist::with(['patient', 'organ'])
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'organ_id' => 'required|exists:organs,id',
            'priority' => 'required|in:low,medium,high',
        ]);

        $waitlist = PatientWaitlist::create([
            'patient_id' => $request->patient_id,
            'organ_id' => $request->organ_id,
            'priority' => $request->priority,
            'status' => 'waiting',
        ]);

        $update_is_transplant = Patient::where('id', $request->patient_id)
        ->update([
            'is_transplant_waitlist' => true,
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Patient added to waitlist',
            'data' => $waitlist
        ], 201);
    }

    public function show($id)
    {
        return PatientWaitlist::with(['patient', 'organ'])
            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $waitlist = PatientWaitlist::findOrFail($id);

        $request->validate([
            'organ_id' => 'required|exists:organs,id', // Add organ_id validation
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:waiting,matched,completed',
        ]);

        // Include organ_id in the update
        $waitlist->update($request->only([
            'organ_id',
            'priority',
            'status'
        ]));

        return response()->json([
            'message' => 'Waitlist updated successfully',
            'data' => $waitlist
        ]);
    }

    public function destroy($id)
    {
        PatientWaitlist::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Waitlist entry deleted'
        ]);
    }
}
