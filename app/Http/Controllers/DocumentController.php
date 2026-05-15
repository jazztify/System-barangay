<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        $query = \App\Models\Issuance::with('resident');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('control_no', 'like', "%{$search}%")
                  ->orWhereHas('resident', function($q) use ($search) {
                      $q->where('last_name', 'like', "%{$search}%");
                  });
        }
        $issuances = $query->latest()->paginate(10);
        return view('documents.index', compact('issuances'));
    }

    public function create(Request $request)
    {
        $resident = null;
        if ($request->filled('resident_id')) {
            $resident = \App\Models\Resident::findOrFail($request->resident_id);
            
            // Clearance Block Logic
            $activeBlotters = \App\Models\BlotterRecord::where('respondent_id', $resident->resident_id)
                ->whereNotIn('status', ['Settled', 'Dismissed'])
                ->count();
            
            if ($activeBlotters > 0 && $request->doc_type == 'Clearance') {
                return redirect()->route('documents.index')->with('error', "Cannot issue Clearance. Resident has {$activeBlotters} active blotter records.");
            }
        }
        
        $residents = \App\Models\Resident::all();
        return view('documents.create', compact('resident', 'residents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'resident_id' => 'required|exists:residents,resident_id',
            'doc_type' => 'required|in:Clearance,Residency,Indigency,JobSeeker',
            'purpose' => 'required|string',
            'or_no' => 'nullable|string',
            'is_free' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $resident = \App\Models\Resident::findOrFail($data['resident_id']);

        // RA 11261 Check (JobSeeker)
        if ($data['doc_type'] == 'JobSeeker') {
            $alreadyAvailed = \App\Models\Issuance::where('resident_id', $resident->resident_id)
                ->where('doc_type', 'JobSeeker')
                ->exists();
            if ($alreadyAvailed) {
                return back()->with('error', 'RA 11261 (First Time Job Seeker) can only be availed once per lifetime.');
            }
            
            $residencyMonths = \Carbon\Carbon::parse($resident->resident_since)->diffInMonths(now());
            if ($residencyMonths < 6) {
                return back()->with('error', 'Resident must have at least 6 months of residency to avail RA 11261 benefits.');
            }
        }

        $year = date('Y');
        $prefix = strtoupper(substr($data['doc_type'], 0, 3));
        $count = \App\Models\Issuance::whereYear('created_at', $year)->count() + 1;
        $data['control_no'] = "{$prefix}-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
        $data['issued_by'] = auth()->id();
        $data['issued_at'] = now();

        $issuance = \App\Models\Issuance::create($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'entity_type' => 'Issuance',
            'entity_id' => $issuance->issuance_id,
            'new_values' => $issuance->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('documents.show', $issuance->issuance_id)->with('success', 'Document issued successfully.');
    }

    public function show(\App\Models\Issuance $issuance)
    {
        $issuance->load(['resident', 'issuer']);
        return view('documents.view', compact('issuance'));
    }

    public function edit(\App\Models\Issuance $issuance)
    {
        $residents = \App\Models\Resident::all();
        return view('documents.edit', compact('issuance', 'residents'));
    }

    public function update(Request $request, \App\Models\Issuance $issuance)
    {
        $data = $request->validate([
            'resident_id' => 'required|exists:residents,resident_id',
            'doc_type' => 'required|in:Clearance,Residency,Indigency,JobSeeker',
            'purpose' => 'required|string',
            'or_no' => 'nullable|string',
            'is_free' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $data['is_free'] = $request->has('is_free');

        $oldValues = $issuance->toArray();
        $issuance->update($data);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'entity_type' => 'Issuance',
            'entity_id' => $issuance->issuance_id,
            'old_values' => $oldValues,
            'new_values' => $issuance->toArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('documents.show', $issuance->issuance_id)->with('success', 'Document updated successfully.');
    }

    public function destroy(\App\Models\Issuance $issuance)
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE',
            'entity_type' => 'Issuance',
            'entity_id' => $issuance->issuance_id,
            'old_values' => $issuance->toArray(),
            'ip_address' => request()->ip(),
        ]);
        $issuance->delete();
        return redirect()->route('documents.index')->with('success', 'Document record deleted.');
    }

    public function print(\App\Models\Issuance $issuance)
    {
        $issuance->load(['resident', 'issuer']);
        $barangay = \App\Models\Setting::where('setting_key', 'barangay_name')->first()->setting_value ?? 'N/A';
        $municipality = \App\Models\Setting::where('setting_key', 'municipality')->first()->setting_value ?? 'N/A';
        $province = \App\Models\Setting::where('setting_key', 'province')->first()->setting_value ?? 'N/A';
        $captain = \App\Models\Setting::where('setting_key', 'punong_barangay')->first()->setting_value ?? 'N/A';

        // Render HTML template for printing (browser print)
        return view('documents.templates.' . strtolower($issuance->doc_type), compact('issuance', 'barangay', 'municipality', 'province', 'captain'));
    }
}