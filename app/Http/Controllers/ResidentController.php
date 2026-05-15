<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{

    public function index(Request $request)
    {
        $query = \App\Models\Resident::with('household');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('purok')) {
            $query->whereHas('household', function($q) use ($request) {
                $q->where('purok_sitio', $request->purok);
            });
        }

        $residents = $query->latest()->paginate(10);
        $puroks = \App\Models\Household::distinct()->pluck('purok_sitio');

        return view('residents.index', compact('residents', 'puroks'));
    }

    public function create()
    {
        $households = \App\Models\Household::all();
        return view('residents.create', compact('households'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'household_id' => 'nullable|exists:households,household_id',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Separated,Divorced',
            'nationality' => 'required|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'resident_since' => 'nullable|date',
            'is_voter' => 'boolean',
            'is_pwd' => 'boolean',
            'is_senior_citizen' => 'boolean',
            'is_solo_parent' => 'boolean',
            'is_4ps' => 'boolean',
        ]);

        $resident = \App\Models\Resident::create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'entity_type' => 'Resident',
            'entity_id' => $resident->resident_id,
            'new_values' => $resident->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('residents.index')->with('success', 'Resident added successfully.');
    }

    public function show(\App\Models\Resident $resident)
    {
        $resident->load(['household', 'complainant_blotters', 'respondent_blotters', 'issuances']);
        return view('residents.profile', compact('resident'));
    }

    public function edit(\App\Models\Resident $resident)
    {
        $households = \App\Models\Household::all();
        return view('residents.edit', compact('resident', 'households'));
    }

    public function update(Request $request, \App\Models\Resident $resident)
    {
        $data = $request->validate([
            'household_id' => 'nullable|exists:households,household_id',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Separated,Divorced',
            'nationality' => 'required|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'resident_since' => 'nullable|date',
            'is_voter' => 'boolean',
            'is_pwd' => 'boolean',
            'is_senior_citizen' => 'boolean',
            'is_solo_parent' => 'boolean',
            'is_4ps' => 'boolean',
        ]);

        $oldValues = $resident->toArray();
        $resident->update($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'entity_type' => 'Resident',
            'entity_id' => $resident->resident_id,
            'old_values' => $oldValues,
            'new_values' => $resident->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('residents.index')->with('success', 'Resident updated successfully.');
    }

    public function destroy(\App\Models\Resident $resident)
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE',
            'entity_type' => 'Resident',
            'entity_id' => $resident->resident_id,
            'old_values' => $resident->toArray(),
            'ip_address' => request()->ip(),
        ]);
        $resident->delete();
        return redirect()->route('residents.index')->with('success', 'Resident soft-deleted.');
    }
}