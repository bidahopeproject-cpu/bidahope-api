<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrganDonation;
use App\Models\PatientWaitlist;
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // ENCODER DASHBOARD (Lightweight query)
        if ($user->role === 'encoder') {
            return response()->json([
                'kidney_supply' => OrganDonation::whereHas('organ', function ($q) {
                    $q->where('name', 'Kidney');
                })->count(),
                'waitlist_total' => PatientWaitlist::count(),
            ]);
        }

        // ADMIN DASHBOARD (Optimized with single query for organ stats)
        $organStats = OrganDonation::query()
            ->select([
                'organ_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT patient_id) as unique_donors')
            ])
            ->with('organ:id,name') // Only select necessary columns
            ->groupBy('organ_id')
            ->get();

        // Get counts in memory (faster than separate queries)
        $totalUniqueDonors = $organStats->sum('unique_donors');
        $waitlistTotal = PatientWaitlist::count();

        // Find min/max in collection
        $sortedStats = $organStats->sortBy('total');
        $lowestOrganSupply = $sortedStats->first();
        $highestOrganSupply = $sortedStats->last();

        return response()->json([
            'total_donors' => $totalUniqueDonors,
            'highest_organ_supply' => $highestOrganSupply,
            'lowest_organ_supply' => $lowestOrganSupply,
            'waitlist_total' => $waitlistTotal,
            // Optional: Include all organ stats if needed
            'organ_statistics' => $organStats,
        ]);
    }
    
    public function charts()
    {
        $start = now()->subMonths(3)->startOfDay();
        $end = now()->endOfDay();

        // 1️⃣ Create default daily dataset
        $chartData = [];

        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $chartData[$date->format('Y-m-d')] = [
                'date' => $date->format('Y-m-d'),
                'total' => 0,
            ];
        }

        // 2️⃣ Fetch summed donations per day
        $rawData = DB::table('organ_donations')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->get();

        // 3️⃣ Merge results
        foreach ($rawData as $row) {
            if (isset($chartData[$row->date])) {
                $chartData[$row->date]['total'] = (int) $row->total;
            }
        }

        return response()->json(array_values($chartData));
    }

}
