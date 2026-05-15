<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlotterController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\BlotterRecord::with(['complainant', 'respondent']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('case_no', 'like', "%{$search}%")
                  ->orWhereHas('complainant', function($q) use ($search) {
                      $q->where('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('respondent', function($q) use ($search) {
                      $q->where('last_name', 'like', "%{$search}%");
                  });
        }

        $blotters = $query->latest()->paginate(10);
        return view('blotters.index', compact('blotters'));
    }

    public function create()
    {
        $residents = \App\Models\Resident::all();
        return view('blotters.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'complainant_id' => 'required|exists:residents,resident_id',
            'respondent_id' => 'required|exists:residents,resident_id',
            'incident_type' => 'required|string|max:100',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string|max:255',
            'narrative' => 'required|string',
        ]);

        $year = date('Y');
        $count = \App\Models\BlotterRecord::whereYear('created_at', $year)->count() + 1;
        $data['case_no'] = "CASE-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
        $data['filed_by'] = auth()->id();
        $data['status'] = 'Unresolved';

        $blotter = \App\Models\BlotterRecord::create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'entity_type' => 'BlotterRecord',
            'entity_id' => $blotter->blotter_id,
            'new_values' => $blotter->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('blotters.index')->with('success', 'Blotter recorded successfully.');
    }

    public function show(\App\Models\BlotterRecord $blotter)
    {
        $blotter->load(['complainant', 'respondent', 'summons', 'filer']);
        return view('blotters.show', compact('blotter'));
    }

    public function edit(\App\Models\BlotterRecord $blotter)
    {
        $residents = \App\Models\Resident::all();
        return view('blotters.edit', compact('blotter', 'residents'));
    }

    public function update(Request $request, \App\Models\BlotterRecord $blotter)
    {
        $data = $request->validate([
            'complainant_id' => 'required|exists:residents,resident_id',
            'respondent_id' => 'required|exists:residents,resident_id',
            'incident_type' => 'required|string|max:100',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string|max:255',
            'narrative' => 'required|string',
            'status' => 'required|string',
        ]);

        if (in_array($data['status'], ['Settled', 'Dismissed', 'Forwarded to Court']) && empty($blotter->resolution_date)) {
            $data['resolution_date'] = now();
        } elseif (!in_array($data['status'], ['Settled', 'Dismissed', 'Forwarded to Court'])) {
            $data['resolution_date'] = null;
        }

        $oldValues = $blotter->toArray();
        $blotter->update($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'entity_type' => 'BlotterRecord',
            'entity_id' => $blotter->blotter_id,
            'old_values' => $oldValues,
            'new_values' => $blotter->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('blotters.index')->with('success', 'Blotter updated successfully.');
    }

    public function destroy(\App\Models\BlotterRecord $blotter)
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE',
            'entity_type' => 'BlotterRecord',
            'entity_id' => $blotter->blotter_id,
            'old_values' => $blotter->toArray(),
            'ip_address' => request()->ip(),
        ]);
        $blotter->delete();
        return redirect()->route('blotters.index')->with('success', 'Blotter record deleted.');
    }

    public function updateStatus(Request $request, \App\Models\BlotterRecord $blotter)
    {
        $request->validate(['status' => 'required|string']);
        $oldValues = $blotter->toArray();
        $blotter->update(['status' => $request->status]);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'entity_type' => 'BlotterRecord',
            'entity_id' => $blotter->blotter_id,
            'old_values' => $oldValues,
            'new_values' => $blotter->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Status updated.');
    }

    public function addSummon(Request $request, \App\Models\BlotterRecord $blotter)
    {
        $data = $request->validate([
            'summon_date' => 'required|date_format:Y-m-d\TH:i',
            'summon_type' => 'required|in:First,Second,Third',
            'notes' => 'nullable|string',
        ]);

        $summon = $blotter->summons()->create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'entity_type' => 'BlotterSummon',
            'entity_id' => $summon->summon_id,
            'new_values' => $summon->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Summon added.');
    }
}