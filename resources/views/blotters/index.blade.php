@extends('layouts.app')

@section('title', 'Blotter & Peace')
@section('header_title', 'Blotter & Peace Order Records')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="row align-items-center">
            <div class="col">
                <form action="{{ route('blotters.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0" placeholder="Search case no, complainant, respondent..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <a href="{{ route('blotters.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> File Blotter
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Case No</th>
                        <th>Complainant</th>
                        <th>Respondent</th>
                        <th>Incident Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blotters as $blotter)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-error-circle fs-4 text-warning"></i>
                                    </div>
                                    <strong>{{ $blotter->case_no }}</strong>
                                </div>
                            </td>
                            <td>{{ $blotter->complainant->full_name ?? 'N/A' }}</td>
                            <td>{{ $blotter->respondent->full_name ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary-subtle text-secondary">{{ $blotter->incident_type }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($blotter->incident_date)->format('M d, Y') }}</td>
                            <td>
                                @php $statusColor = match($blotter->status) {
                                    'Settled' => 'success',
                                    'Dismissed' => 'info',
                                    'Unresolved' => 'warning',
                                    'Escalated' => 'danger',
                                    default => 'secondary'
                                }; @endphp
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-2 py-1">{{ $blotter->status }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('blotters.show', $blotter->blotter_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="far fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No blotter records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0">
        {{ $blotters->links() }}
    </div>
</div>
@endsection
