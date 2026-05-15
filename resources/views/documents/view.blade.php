@extends('layouts.app')

@section('title', $issuance->control_no)
@section('header_title', 'Document Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-file-alt text-primary me-2"></i>
                    <strong>{{ $issuance->control_no }}</strong>
                </div>
                <a href="{{ route('documents.print', $issuance->issuance_id) }}" class="btn btn-sm btn-success" target="_blank">
                    <i class="fas fa-print me-1"></i> Print PDF
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Document Type</label>
                        @php $typeColor = match($issuance->doc_type) {
                            'Clearance' => 'success',
                            'Residency' => 'primary',
                            'Indigency' => 'warning',
                            'JobSeeker' => 'info',
                            default => 'secondary'
                        }; @endphp
                        <div><span class="badge bg-{{ $typeColor }}-subtle text-{{ $typeColor }} fs-6">{{ $issuance->doc_type }}</span></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Control Number</label>
                        <div class="fw-bold">{{ $issuance->control_no }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Resident</label>
                        <div class="fw-bold">
                            @if($issuance->resident)
                                <a href="{{ route('residents.show', $issuance->resident->resident_id) }}" class="text-decoration-none">
                                    {{ $issuance->resident->full_name }}
                                </a>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Purpose</label>
                        <div class="fw-bold">{{ $issuance->purpose }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">OR Number</label>
                        <div class="fw-bold">{{ $issuance->or_no ?? ($issuance->is_free ? 'FREE' : 'N/A') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Issued At</label>
                        <div class="fw-bold">{{ \Carbon\Carbon::parse($issuance->issued_at)->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Issued By</label>
                        <div class="fw-bold">{{ $issuance->issuer->full_name ?? 'System' }}</div>
                    </div>
                    @if($issuance->remarks)
                        <div class="col-12">
                            <label class="text-muted small">Remarks</label>
                            <div class="p-3 bg-light rounded">{{ $issuance->remarks }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Documents
                </a>
                <div>
                    <a href="{{ route('documents.edit', $issuance->issuance_id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('documents.destroy', $issuance->issuance_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document record? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
