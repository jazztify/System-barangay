@extends('layouts.app')

@section('title', 'Household ' . $household->household_no)
@section('header_title', 'Household Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bx bx-home fs-1 text-primary"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $household->household_no }}</h5>
                <p class="text-muted mb-0">{{ $household->head_name ?? 'No Head Assigned' }}</p>
            </div>
            <div class="card-body border-top">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Purok/Sitio</span>
                        <strong>{{ $household->purok_sitio }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Address</span>
                        <strong class="text-end" style="max-width: 200px;">{{ $household->address }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Members</span>
                        <strong>{{ $household->residents->count() }}</strong>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 d-flex gap-2 pb-3">
                <a href="{{ route('households.edit', $household->household_id) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="far fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('households.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-transparent">
                <i class="fas fa-users text-primary me-2"></i> Household Members
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Name</th>
                                <th>Age/Sex</th>
                                <th>Civil Status</th>
                                <th>Occupation</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($household->residents as $resident)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('residents.show', $resident->resident_id) }}" class="text-decoration-none fw-bold">
                                            {{ $resident->full_name }}
                                        </a>
                                    </td>
                                    <td>{{ $resident->age }} / {{ $resident->sex }}</td>
                                    <td>{{ $resident->civil_status }}</td>
                                    <td>{{ $resident->occupation ?? 'N/A' }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('residents.show', $resident->resident_id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No members found in this household.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
