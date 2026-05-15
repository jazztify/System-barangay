@extends('layouts.app')

@section('title', 'Households')
@section('header_title', 'Household Management')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="row align-items-center">
            <div class="col">
                <form action="{{ route('households.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0" placeholder="Search household no, head, purok..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <a href="{{ route('households.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Household
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Household No</th>
                        <th>Head of Household</th>
                        <th>Purok/Sitio</th>
                        <th>Address</th>
                        <th>Members</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($households as $household)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-home fs-4 text-secondary"></i>
                                    </div>
                                    <strong>{{ $household->household_no }}</strong>
                                </div>
                            </td>
                            <td>{{ $household->head_name ?? 'Not Assigned' }}</td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ $household->purok_sitio }}</span></td>
                            <td>{{ Str::limit($household->address, 40) }}</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">{{ $household->residents_count ?? $household->residents()->count() }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li><a class="dropdown-item" href="{{ route('households.show', $household->household_id) }}"><i class="far fa-eye me-2"></i> View</a></li>
                                        <li><a class="dropdown-item" href="{{ route('households.edit', $household->household_id) }}"><i class="far fa-edit me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('households.destroy', $household->household_id) }}" method="POST" onsubmit="return confirm('Delete this household?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="far fa-trash-alt me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No households found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0">
        {{ $households->links() }}
    </div>
</div>
@endsection
