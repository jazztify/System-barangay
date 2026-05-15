<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [
            'total_residents' => \App\Models\Resident::count(),
            'total_households' => \App\Models\Household::count(),
            'active_blotters' => \App\Models\BlotterRecord::whereIn('status', ['Unresolved', 'Scheduled', 'Mediation'])->count(),
            'total_issuances' => \App\Models\Issuance::count(),
            'voters' => \App\Models\Resident::where('is_voter', true)->count(),
            'pwd' => \App\Models\Resident::where('is_pwd', true)->count(),
            'senior' => \App\Models\Resident::where('is_senior_citizen', true)->count(),
            '4ps' => \App\Models\Resident::where('is_4ps', true)->count(),
        ];

        $recent_logs = \App\Models\AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_logs'));
    }
}