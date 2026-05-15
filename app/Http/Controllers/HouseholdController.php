<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Household::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('household_no', 'like', "%{$search}%")
                  ->orWhere('head_name', 'like', "%{$search}%")
                  ->orWhere('purok_sitio', 'like', "%{$search}%");
        }

        $households = $query->latest()->paginate(10);
        return view('households.index', compact('households'));
    }

    public function create()
    {
        return view('households.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'household_no' => 'required|string|max:20|unique:households',
            'purok_sitio' => 'required|string|max:100',
            'address' => 'required|string',
            'head_name' => 'nullable|string|max:200',
        ]);

        $household = \App\Models\Household::create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'entity_type' => 'Household',
            'entity_id' => $household->household_id,
            'new_values' => $household->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('households.index')->with('success', 'Household added successfully.');
    }

    public function show(\App\Models\Household $household)
    {
        $household->load('residents');
        return view('households.show', compact('household'));
    }

    public function edit(\App\Models\Household $household)
    {
        return view('households.edit', compact('household'));
    }

    public function update(Request $request, \App\Models\Household $household)
    {
        $data = $request->validate([
            'household_no' => 'required|string|max:20|unique:households,household_no,' . $household->household_id . ',household_id',
            'purok_sitio' => 'required|string|max:100',
            'address' => 'required|string',
            'head_name' => 'nullable|string|max:200',
        ]);

        $oldValues = $household->toArray();
        $household->update($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'entity_type' => 'Household',
            'entity_id' => $household->household_id,
            'old_values' => $oldValues,
            'new_values' => $household->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('households.index')->with('success', 'Household updated successfully.');
    }

    public function destroy(\App\Models\Household $household)
    {
        $household->delete();
        return redirect()->route('households.index')->with('success', 'Household soft-deleted.');
    }
}
