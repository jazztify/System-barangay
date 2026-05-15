@extends('layouts.app')

@section('title', 'Add Household')
@section('header_title', 'Add New Household')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('households.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Household Information</h5>
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

        <form action="{{ route('households.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Household No <span class="text-danger">*</span></label>
                    <input type="text" name="household_no" class="form-control" value="{{ old('household_no') }}" placeholder="e.g. HH-2026-001" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Head of Household</label>
                    <input type="text" name="head_name" class="form-control" value="{{ old('head_name') }}" placeholder="Full name of household head">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Purok / Sitio <span class="text-danger">*</span></label>
                    <input type="text" name="purok_sitio" class="form-control" value="{{ old('purok_sitio') }}" placeholder="e.g. Purok 1" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Complete Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('households.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Household
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
