@extends('layouts.app')

@section('title', 'Settings')
@section('header_title', 'System Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf

            {{-- Barangay Information --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <i class="fas fa-landmark text-primary me-2"></i> Barangay Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Barangay Name <span class="text-danger">*</span></label>
                            <input type="text" name="barangay_name" class="form-control" value="{{ $settings['barangay_name'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Municipality / City <span class="text-danger">*</span></label>
                            <input type="text" name="municipality" class="form-control" value="{{ $settings['municipality'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Province <span class="text-danger">*</span></label>
                            <input type="text" name="province" class="form-control" value="{{ $settings['province'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Region</label>
                            <input type="text" name="region" class="form-control" value="{{ $settings['region'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Complete Address</label>
                            <input type="text" name="barangay_address" class="form-control" value="{{ $settings['barangay_address'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" value="{{ $settings['contact_no'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Officials --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <i class="fas fa-user-tie text-primary me-2"></i> Barangay Officials
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Punong Barangay (Captain) <span class="text-danger">*</span></label>
                            <input type="text" name="punong_barangay" class="form-control" value="{{ $settings['punong_barangay'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Barangay Secretary</label>
                            <input type="text" name="barangay_secretary" class="form-control" value="{{ $settings['barangay_secretary'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Barangay Treasurer</label>
                            <input type="text" name="barangay_treasurer" class="form-control" value="{{ $settings['barangay_treasurer'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Settings --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <i class="fas fa-file-alt text-primary me-2"></i> Document Settings
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Clearance Fee (PHP)</label>
                            <input type="text" name="clearance_fee" class="form-control" value="{{ $settings['clearance_fee'] ?? '50.00' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Residency Fee (PHP)</label>
                            <input type="text" name="residency_fee" class="form-control" value="{{ $settings['residency_fee'] ?? '30.00' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Indigency Fee (PHP)</label>
                            <input type="text" name="indigency_fee" class="form-control" value="{{ $settings['indigency_fee'] ?? '0.00' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
