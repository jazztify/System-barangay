@extends('layouts.app')

@section('title', $blotter->case_no)
@section('header_title', 'Blotter Case Details')

@section('content')
<div class="row">
    {{-- Case Info --}}
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center py-4">
                @php $statusColor = match($blotter->status) {
                    'Settled' => 'success',
                    'Dismissed' => 'info',
                    'Unresolved' => 'warning',
                    'Escalated' => 'danger',
                    default => 'secondary'
                }; @endphp
                <div class="bg-{{ $statusColor }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bx bx-error-circle fs-1 text-{{ $statusColor }}"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $blotter->case_no }}</h5>
                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-3 py-1">{{ $blotter->status }}</span>
            </div>
            <div class="card-body border-top">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Type</span>
                        <strong>{{ $blotter->incident_type }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Date</span>
                        <strong>{{ \Carbon\Carbon::parse($blotter->incident_date)->format('M d, Y') }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Location</span>
                        <strong>{{ $blotter->incident_location ?? 'N/A' }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Filed By</span>
                        <strong>{{ $blotter->filer->full_name ?? 'System' }}</strong>
                    </li>
                </ul>
            </div>
            {{-- Update Status --}}
            <div class="card-body border-top">
                <h6 class="fw-bold mb-3">Update Status</h6>
                <form action="{{ route('blotters.update-status', $blotter->blotter_id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select name="status" class="form-select">
                            @foreach(['Unresolved', 'Settled', 'Escalated', 'Dismissed'] as $s)
                                <option value="{{ $s }}" {{ $blotter->status==$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Parties --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <i class="fas fa-user text-success me-2"></i> Complainant
                    </div>
                    <div class="card-body">
                        @if($blotter->complainant)
                            <h6 class="fw-bold mb-1">{{ $blotter->complainant->full_name }}</h6>
                            <p class="text-muted small mb-1">{{ $blotter->complainant->sex }}, {{ $blotter->complainant->age }} yrs old</p>
                            <p class="text-muted small mb-0">{{ $blotter->complainant->household->purok_sitio ?? 'N/A' }}</p>
                            <a href="{{ route('residents.show', $blotter->complainant->resident_id) }}" class="btn btn-sm btn-outline-primary mt-2">View Profile</a>
                        @else
                            <p class="text-muted mb-0">N/A</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <i class="fas fa-user text-danger me-2"></i> Respondent
                    </div>
                    <div class="card-body">
                        @if($blotter->respondent)
                            <h6 class="fw-bold mb-1">{{ $blotter->respondent->full_name }}</h6>
                            <p class="text-muted small mb-1">{{ $blotter->respondent->sex }}, {{ $blotter->respondent->age }} yrs old</p>
                            <p class="text-muted small mb-0">{{ $blotter->respondent->household->purok_sitio ?? 'N/A' }}</p>
                            <a href="{{ route('residents.show', $blotter->respondent->resident_id) }}" class="btn btn-sm btn-outline-primary mt-2">View Profile</a>
                        @else
                            <p class="text-muted mb-0">N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Narrative --}}
        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <i class="fas fa-align-left text-primary me-2"></i> Narrative / Details
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-wrap;">{{ $blotter->narrative }}</p>
            </div>
        </div>

        {{-- Summons --}}
        <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span><i class="fas fa-gavel text-warning me-2"></i> Summons History</span>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addSummonForm">
                    <i class="fas fa-plus me-1"></i> Add Summon
                </button>
            </div>

            {{-- Add Summon Form --}}
            <div class="collapse" id="addSummonForm">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('blotters.add-summon', $blotter->blotter_id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Summon Type <span class="text-danger">*</span></label>
                                <select name="summon_type" class="form-select" required>
                                    <option value="First">First Summon</option>
                                    <option value="Second">Second Summon</option>
                                    <option value="Third">Third Summon</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Schedule Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="summon_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Notes</label>
                                <input type="text" name="notes" class="form-control" placeholder="Optional notes">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i> Save Summon
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Type</th>
                                <th>Scheduled Date</th>
                                <th>Notes</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blotter->summons as $i => $summon)
                                <tr>
                                    <td class="ps-3">{{ $i + 1 }}</td>
                                    <td>
                                        @php $summonColor = match($summon->summon_type) {
                                            'First' => 'primary',
                                            'Second' => 'warning',
                                            'Third' => 'danger',
                                            default => 'secondary'
                                        }; @endphp
                                        <span class="badge bg-{{ $summonColor }}-subtle text-{{ $summonColor }}">{{ $summon->summon_type }} Summon</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($summon->summon_date)->format('M d, Y h:i A') }}</td>
                                    <td>{{ $summon->notes ?? '—' }}</td>
                                    <td class="text-muted small">{{ $summon->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No summons issued yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between">
    <a href="{{ route('blotters.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Blotters
    </a>
    <div>
        <a href="{{ route('blotters.edit', $blotter->blotter_id) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <form action="{{ route('blotters.destroy', $blotter->blotter_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blotter record? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection
