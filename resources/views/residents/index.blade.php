@extends('layouts.app')

@section('title', 'Residents')
@section('header_title', 'Registry of Barangay Inhabitants (RBI)')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="row align-items-center">
            <div class="col">
                <form action="{{ route('residents.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0" placeholder="Search name..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <select name="purok" class="form-select ms-2" onchange="this.form.submit()">
                        <option value="">All Puroks</option>
                        @foreach($puroks as $purok)
                            <option value="{{ $purok }}" {{ request('purok') == $purok ? 'selected' : '' }}>{{ $purok }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-auto">
                <a href="{{ route('residents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Resident
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Full Name</th>
                        <th>Age/Sex</th>
                        <th>Purok/Sitio</th>
                        <th>Voter?</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-user fs-4 text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $resident->full_name }}</div>
                                        <div class="small text-muted">{{ $resident->occupation ?? 'No Occupation' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $resident->age }} yrs old</div>
                                <div class="small text-muted">{{ $resident->sex }}</div>
                            </td>
                            <td>{{ $resident->household->purok_sitio ?? 'N/A' }}</td>
                            <td>
                                @if($resident->is_voter)
                                    <span class="badge bg-success-subtle text-success border-0 px-2 py-1">Yes</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border-0 px-2 py-1">No</span>
                                @endif
                            </td>
                            <td>
                                @if($resident->is_active)
                                    <span class="badge bg-primary-subtle text-primary border-0 px-2 py-1">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border-0 px-2 py-1">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item" href="{{ route('residents.show', $resident->resident_id) }}"><i class="far fa-id-card me-2"></i> Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('residents.edit', $resident->resident_id) }}"><i class="far fa-edit me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('residents.destroy', $resident->resident_id) }}" method="POST" onsubmit="return confirm('Archive this resident?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="far fa-trash-alt me-2"></i> Archive</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No residents found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0">
        {{ $residents->links() }}
    </div>
</div>
@endsection
