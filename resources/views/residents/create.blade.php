@extends('layouts.app')

@section('title', 'Add Resident')
@section('header_title', 'Add New Resident')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('residents.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Resident Information Form</h5>
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

        <form action="{{ route('residents.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                {{-- Personal Information --}}
                <div class="col-12">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-user me-1"></i> Personal Information
                    </h6>
                </div>

                <div class="col-md-3">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix" class="form-control" value="{{ old('suffix') }}" placeholder="Jr., Sr., III">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sex <span class="text-danger">*</span></label>
                    <select name="sex" class="form-select" required>
                        <option value="">Select</option>
                        <option value="Male" {{ old('sex')=='Male'?'selected':'' }}>Male</option>
                        <option value="Female" {{ old('sex')=='Female'?'selected':'' }}>Female</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Civil Status <span class="text-danger">*</span></label>
                    <select name="civil_status" class="form-select" required>
                        <option value="">Select</option>
                        @foreach(['Single','Married','Widowed','Separated','Divorced'] as $cs)
                            <option value="{{ $cs }}" {{ old('civil_status')==$cs?'selected':'' }}>{{ $cs }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Filipino') }}" required>
                </div>

                {{-- Contact & Occupation --}}
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-phone me-1"></i> Contact & Occupation
                    </h6>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Occupation</label>
                    <input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contact No.</label>
                    <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no') }}" placeholder="09XXXXXXXXX">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                {{-- Household & Residency --}}
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-home me-1"></i> Household & Residency
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Household</label>
                    <select name="household_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($households as $h)
                            <option value="{{ $h->household_id }}" {{ old('household_id')==$h->household_id?'selected':'' }}>
                                {{ $h->household_no }} — {{ $h->head_name ?? 'No Head' }} ({{ $h->purok_sitio }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Resident Since</label>
                    <input type="date" name="resident_since" class="form-control" value="{{ old('resident_since') }}">
                </div>

                {{-- Flags --}}
                <div class="col-12 mt-4">
                    <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">
                        <i class="bx bx-flag me-1"></i> Classification Flags
                    </h6>
                </div>

                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        @foreach([
                            'is_voter' => 'Registered Voter',
                            'is_pwd' => 'PWD',
                            'is_senior_citizen' => 'Senior Citizen',
                            'is_solo_parent' => 'Solo Parent',
                            'is_4ps' => '4Ps Member',
                        ] as $field => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" id="{{ $field }}" {{ old($field) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('residents.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Resident
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
