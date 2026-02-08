<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransplantSchedule;
use App\Models\PatientWaitlist;
use Illuminate\Http\Request;

class TransplantScheduleController extends Controller
{
    public function index()
    {
        return TransplantSchedule::with(['patient', 'organ', 'waitlist'])
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'organ_id' => 'required|exists:organs,id',
            'patient_waitlist_id' => 'nullable|exists:patient_waitlists,id',
            'schedule_date' => 'required|date',
            'schedule_time' => 'nullable',
            'remarks' => 'nullable|string',
        ]);

        $schedule = TransplantSchedule::create([
            'patient_id' => $request->patient_id,
            'organ_id' => $request->organ_id,
            'patient_waitlist_id' => $request->patient_waitlist_id,
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'remarks' => $request->remarks,
            'status' => 'scheduled',
        ]);

        // Auto update waitlist if linked
        if ($request->patient_waitlist_id) {
            PatientWaitlist::where('id', $request->patient_waitlist_id)
                ->update(['status' => 'matched']);
        }

        return response()->json([
            'message' => 'Transplant scheduled successfully',
            'data' => $schedule
        ], 201);
    }

    public function show($id)
    {
        return TransplantSchedule::with(['patient', 'organ', 'waitlist'])
            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $schedule = TransplantSchedule::findOrFail($id);

        $request->validate([
            'schedule_date' => 'required|date',
            'schedule_time' => 'nullable',
            'status' => 'required|in:scheduled,completed,cancelled',
            'remarks' => 'nullable|string',
        ]);

        $schedule->update($request->all());

        return response()->json([
            'message' => 'Transplant schedule updated',
            'data' => $schedule
        ]);
    }

    public function destroy($id)
    {
        TransplantSchedule::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Transplant schedule deleted'
        ]);
    }
}