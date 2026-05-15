@extends('layouts.app')

@section('title', 'Edit Household')
@section('header_title', 'Edit Household')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="d-flex align-items-center">
            <a href="{{ route('households.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h5 class="mb-0">Edit Household: {{ $household->household_no }}</h5>
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

        <form action="{{ route('households.update', $household->household_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Household No <span class="text-danger">*</span></label>
                    <input type="text" name="household_no" class="form-control" value="{{ old('household_no', $household->household_no) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Head of Household</label>
                    <input type="text" name="head_name" class="form-control" value="{{ old('head_name', $household->head_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Purok / Sitio <span class="text-danger">*</span></label>
                    <input type="text" name="purok_sitio" class="form-control" value="{{ old('purok_sitio', $household->purok_sitio) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Complete Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $household->address) }}" required>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('households.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Household
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
