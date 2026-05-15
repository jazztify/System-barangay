@extends('layouts.app')

@section('title', 'File Blotter')
@section('header_title', 'File New Blotter Record')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('blotters.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Blotter / Complaint Form</h5>
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

        <form action="{{ route('blotters.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                {{-- Parties --}}
                <div class="col-12">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-user-check me-1"></i> Parties Involved
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Complainant <span class="text-danger">*</span></label>
                    <select name="complainant_id" class="form-select" required>
                        <option value="">-- Select Complainant --</option>
                        @foreach($residents as $r)
                            <option value="{{ $r->resident_id }}" {{ old('complainant_id')==$r->resident_id?'selected':'' }}>
                                {{ $r->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Respondent <span class="text-danger">*</span></label>
                    <select name="respondent_id" class="form-select" required>
                        <option value="">-- Select Respondent --</option>
                        @foreach($residents as $r)
                            <option value="{{ $r->resident_id }}" {{ old('respondent_id')==$r->resident_id?'selected':'' }}>
                                {{ $r->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Incident Details --}}
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-detail me-1"></i> Incident Details
                    </h6>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Incident Type <span class="text-danger">*</span></label>
                    <select name="incident_type" class="form-select" required>
                        <option value="">-- Select --</option>
                        @foreach(['Physical Assault', 'Verbal Abuse', 'Theft', 'Property Damage', 'Domestic Violence', 'Trespassing', 'Noise Complaint', 'Harassment', 'Land Dispute', 'Others'] as $type)
                            <option value="{{ $type }}" {{ old('incident_type')==$type?'selected':'' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Incident Date <span class="text-danger">*</span></label>
                    <input type="date" name="incident_date" class="form-control" value="{{ old('incident_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Incident Location</label>
                    <input type="text" name="incident_location" class="form-control" value="{{ old('incident_location') }}" placeholder="Where the incident happened">
                </div>
                <div class="col-12">
                    <label class="form-label">Narrative / Details <span class="text-danger">*</span></label>
                    <textarea name="narrative" class="form-control" rows="6" required placeholder="Provide a detailed account of the incident...">{{ old('narrative') }}</textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('blotters.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> File Blotter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
