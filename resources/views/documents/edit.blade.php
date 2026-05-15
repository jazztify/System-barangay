@extends('layouts.app')

@section('title', 'Edit Document')
@section('header_title', 'Edit Document Issuance: ' . $issuance->control_no)

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('documents.show', $issuance->issuance_id) }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Edit Document Form</h5>
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

        <form action="{{ route('documents.update', $issuance->issuance_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Select Resident <span class="text-danger">*</span></label>
                    <select name="resident_id" class="form-select" required>
                        <option value="">-- Choose Resident --</option>
                        @foreach($residents as $r)
                            <option value="{{ $r->resident_id }}" {{ old('resident_id', $issuance->resident_id) == $r->resident_id ? 'selected' : '' }}>
                                {{ $r->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Document Type <span class="text-danger">*</span></label>
                    <select name="doc_type" class="form-select" required>
                        <option value="">-- Choose Type --</option>
                        @foreach(['Clearance', 'Residency', 'Indigency', 'JobSeeker'] as $type)
                            <option value="{{ $type }}" {{ old('doc_type', $issuance->doc_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Purpose <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control" value="{{ old('purpose', $issuance->purpose) }}" required placeholder="e.g. Employment, Local Employment, Bank Requirement">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Official Receipt (OR) Number</label>
                    <input type="text" name="or_no" class="form-control" value="{{ old('or_no', $issuance->or_no) }}" placeholder="Leave blank if free">
                </div>

                <div class="col-md-6 d-flex align-items-center mt-md-4 pt-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_free" value="1" class="form-check-input" id="is_free" {{ old('is_free', $issuance->is_free) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_free">Free of Charge</label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3" placeholder="Optional notes">{{ old('remarks', $issuance->remarks) }}</textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('documents.show', $issuance->issuance_id) }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Document
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
