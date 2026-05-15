@extends('layouts.app')

@section('title', 'Issuances & Documents')
@section('header_title', 'Document Issuance Management')

@section('content')
<div class="card">
    <div class="card-header border-0 bg-transparent">
        <div class="row align-items-center">
            <div class="col">
                <form action="{{ route('documents.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control border-end-0" placeholder="Search control no or name..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary border-start-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <a href="{{ route('documents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Issue Document
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Control No</th>
                        <th>Resident</th>
                        <th>Document Type</th>
                        <th>Purpose</th>
                        <th>OR No</th>
                        <th>Issued At</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issuances as $doc)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-file fs-4 text-primary"></i>
                                    </div>
                                    <strong>{{ $doc->control_no }}</strong>
                                </div>
                            </td>
                            <td>{{ $doc->resident->full_name ?? 'N/A' }}</td>
                            <td>
                                @php $typeColor = match($doc->doc_type) {
                                    'Clearance' => 'success',
                                    'Residency' => 'primary',
                                    'Indigency' => 'warning',
                                    'JobSeeker' => 'info',
                                    default => 'secondary'
                                }; @endphp
                                <span class="badge bg-{{ $typeColor }}-subtle text-{{ $typeColor }}">{{ $doc->doc_type }}</span>
                            </td>
                            <td>{{ Str::limit($doc->purpose, 30) }}</td>
                            <td>{{ $doc->or_no ?? ($doc->is_free ? 'FREE' : '—') }}</td>
                            <td>{{ \Carbon\Carbon::parse($doc->issued_at)->format('M d, Y') }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('documents.show', $doc->issuance_id) }}" class="btn btn-outline-primary" title="View">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documents.print', $doc->issuance_id) }}" class="btn btn-outline-success" title="Print PDF" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No documents issued yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0">
        {{ $issuances->links() }}
    </div>
</div>
@endsection
