<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrganDonation;
use Illuminate\Http\Request;

class OrganDonationController extends Controller
{
    // GET ALL DONATIONS
    public function index()
    {
        return OrganDonation::with(['patient', 'organ'])
            ->latest()
            ->get();
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'organ_id' => 'required|exists:organs,id',
            'donation_date' => 'required|date',
            'status' => 'required|in:available,used,expired',
        ]);

        $donation = OrganDonation::create($request->all());

        return response()->json([
            'message' => 'Organ donation recorded successfully',
            'data' => $donation
        ], 201);
    }

    // SHOW
    public function show($id)
    {
        return OrganDonation::with(['patient', 'organ'])
            ->findOrFail($id);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $donation = OrganDonation::findOrFail($id);

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'organ_id' => 'required|exists:organs,id',
            'donation_date' => 'required|date',
            'status' => 'required|in:available,used,expired',
        ]);

        $donation->update($request->all());

        return response()->json([
            'message' => 'Organ donation updated successfully',
            'data' => $donation
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        OrganDonation::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Organ donation deleted successfully'
        ]);
    }
}