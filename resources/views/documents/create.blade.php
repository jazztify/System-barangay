@extends('layouts.app')

@section('title', 'Issue Document')
@section('header_title', 'Issue New Document')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Document Issuance Form</h5>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger border-0">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                {{-- Resident Selection --}}
                <div class="col-12">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-user me-1"></i> Requesting Resident
                    </h6>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Select Resident <span class="text-danger">*</span></label>
                    <select name="resident_id" class="form-select" required>
                        <option value="">-- Choose a Resident --</option>
                        @foreach($residents as $r)
                            <option value="{{ $r->resident_id }}" {{ (old('resident_id', $resident->resident_id ?? ''))==$r->resident_id?'selected':'' }}>
                                {{ $r->full_name }} — {{ $r->household->purok_sitio ?? 'No Household' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Document Type <span class="text-danger">*</span></label>
                    <select name="doc_type" class="form-select" required>
                        <option value="">-- Select --</option>
                        <option value="Clearance" {{ old('doc_type')=='Clearance'?'selected':'' }}>Barangay Clearance</option>
                        <option value="Residency" {{ old('doc_type')=='Residency'?'selected':'' }}>Certificate of Residency</option>
                        <option value="Indigency" {{ old('doc_type')=='Indigency'?'selected':'' }}>Certificate of Indigency</option>
                        <option value="JobSeeker" {{ old('doc_type')=='JobSeeker'?'selected':'' }}>First Time Job Seeker (RA 11261)</option>
                    </select>
                </div>

                {{-- Details --}}
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-detail me-1"></i> Document Details
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Purpose <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control" value="{{ old('purpose') }}" placeholder="e.g. Employment, School Requirement" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">OR Number</label>
                    <input type="text" name="or_no" class="form-control" value="{{ old('or_no') }}" placeholder="Official Receipt No.">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="is_free" value="1" id="is_free" {{ old('is_free') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_free">Issue for FREE</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3" placeholder="Optional remarks or notes...">{{ old('remarks') }}</textarea>
                </div>
            </div>

            {{-- RA 11261 Info Box --}}
            <div class="alert alert-info border-0 mt-4" style="background: #e0f2fe;">
                <i class="fas fa-info-circle me-2"></i>
                <strong>RA 11261 (First Time Job Seeker Act):</strong> This benefit can only be availed once per lifetime. The resident must have at least 6 months of residency in the barangay. The system automatically validates these conditions.
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('documents.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-alt me-1"></i> Issue Document
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
