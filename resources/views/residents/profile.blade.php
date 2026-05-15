@extends('layouts.app')

@section('title', $resident->full_name)
@section('header_title', 'Resident Profile')

@section('content')
<div class="row">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bx bx-user fs-1 text-primary"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $resident->full_name }}</h5>
                <p class="text-muted mb-3">{{ $resident->occupation ?? 'No Occupation' }}</p>

                @if($resident->is_active)
                    <span class="badge bg-primary-subtle text-primary px-3 py-1">Active</span>
                @else
                    <span class="badge bg-danger-subtle text-danger px-3 py-1">Inactive</span>
                @endif
            </div>
            <div class="card-body border-top">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Age</span>
                        <strong>{{ $resident->age }} years old</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Sex</span>
                        <strong>{{ $resident->sex }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Civil Status</span>
                        <strong>{{ $resident->civil_status }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Birthday</span>
                        <strong>{{ \Carbon\Carbon::parse($resident->date_of_birth)->format('M d, Y') }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Contact</span>
                        <strong>{{ $resident->contact_no ?? 'N/A' }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Email</span>
                        <strong>{{ $resident->email ?? 'N/A' }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Nationality</span>
                        <strong>{{ $resident->nationality }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Resident Since</span>
                        <strong>{{ $resident->resident_since ? \Carbon\Carbon::parse($resident->resident_since)->format('M Y') : 'N/A' }}</strong>
                    </li>
                </ul>
            </div>
            <div class="card-body border-top">
                <h6 class="fw-bold mb-2">Classification</h6>
                <div class="d-flex flex-wrap gap-2">
                    @if($resident->is_voter)
                        <span class="badge bg-success-subtle text-success">Voter</span>
                    @endif
                    @if($resident->is_pwd)
                        <span class="badge bg-info-subtle text-info">PWD</span>
                    @endif
                    @if($resident->is_senior_citizen)
                        <span class="badge bg-warning-subtle text-warning">Senior Citizen</span>
                    @endif
                    @if($resident->is_solo_parent)
                        <span class="badge bg-danger-subtle text-danger">Solo Parent</span>
                    @endif
                    @if($resident->is_4ps)
                        <span class="badge bg-primary-subtle text-primary">4Ps</span>
                    @endif
                </div>
            </div>
            <div class="card-body border-top">
                <h6 class="fw-bold mb-2">Household</h6>
                @if($resident->household)
                    <p class="mb-1"><strong>{{ $resident->household->household_no }}</strong></p>
                    <p class="text-muted small mb-0">{{ $resident->household->purok_sitio }} — {{ $resident->household->address }}</p>
                @else
                    <p class="text-muted mb-0">Not assigned to any household.</p>
                @endif
            </div>
            <div class="card-footer bg-transparent border-0 d-flex gap-2 pb-3">
                <a href="{{ route('residents.edit', $resident->resident_id) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="far fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('documents.create', ['resident_id' => $resident->resident_id]) }}" class="btn btn-outline-primary btn-sm flex-fill">
                    <i class="fas fa-file-alt me-1"></i> Issue Document
                </a>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-md-8">
        {{-- Blotter Records as Complainant --}}
        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i> Blotter Records (Complainant)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Case No</th>
                                <th>Respondent</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resident->complainant_blotters as $b)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('blotters.show', $b->blotter_id) }}" class="text-decoration-none fw-bold">{{ $b->case_no }}</a>
                                    </td>
                                    <td>{{ $b->respondent->full_name ?? 'N/A' }}</td>
                                    <td>{{ $b->incident_type }}</td>
                                    <td>
                                        @php $statusColor = match($b->status) {
                                            'Settled' => 'success',
                                            'Unresolved' => 'warning',
                                            'Escalated' => 'danger',
                                            default => 'secondary'
                                        }; @endphp
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">{{ $b->status }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($b->incident_date)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No blotter records filed.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Blotter Records as Respondent --}}
        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <i class="fas fa-gavel text-danger me-2"></i> Blotter Records (Respondent)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Case No</th>
                                <th>Complainant</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resident->respondent_blotters as $b)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('blotters.show', $b->blotter_id) }}" class="text-decoration-none fw-bold">{{ $b->case_no }}</a>
                                    </td>
                                    <td>{{ $b->complainant->full_name ?? 'N/A' }}</td>
                                    <td>{{ $b->incident_type }}</td>
                                    <td>
                                        @php $statusColor = match($b->status) {
                                            'Settled' => 'success',
                                            'Unresolved' => 'warning',
                                            'Escalated' => 'danger',
                                            default => 'secondary'
                                        }; @endphp
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">{{ $b->status }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($b->incident_date)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No blotter records as respondent.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Issued Documents --}}
        <div class="card">
            <div class="card-header bg-transparent">
                <i class="fas fa-file-alt text-primary me-2"></i> Issued Documents
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Control No</th>
                                <th>Type</th>
                                <th>Purpose</th>
                                <th>Issued At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resident->issuances as $doc)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('documents.show', $doc->issuance_id) }}" class="text-decoration-none fw-bold">{{ $doc->control_no }}</a>
                                    </td>
                                    <td>{{ $doc->doc_type }}</td>
                                    <td>{{ Str::limit($doc->purpose, 40) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($doc->issued_at)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">No documents issued.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Residents
    </a>
</div>
@endsection
