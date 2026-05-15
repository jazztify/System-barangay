@extends('layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="card bg-primary text-white mb-4 overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold mb-0">{{ $stats['total_residents'] }}</h2>
                        <p class="mb-0">Total Residents</p>
                    </div>
                    <i class="bx bxs-group fs-1 opacity-50"></i>
                </div>
            </div>
            <a href="{{ route('residents.index') }}" class="card-footer bg-black bg-opacity-10 text-white d-flex align-items-center justify-content-between py-2 text-decoration-none">
                <span class="small">View Details</span>
                <i class="bx bx-chevron-right small"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card bg-success text-white mb-4 overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold mb-0">{{ $stats['total_households'] }}</h2>
                        <p class="mb-0">Households</p>
                    </div>
                    <i class="bx bxs-home fs-1 opacity-50"></i>
                </div>
            </div>
            <a href="{{ route('households.index') }}" class="card-footer bg-black bg-opacity-10 text-white d-flex align-items-center justify-content-between py-2 text-decoration-none">
                <span class="small">View Details</span>
                <i class="bx bx-chevron-right small"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card bg-warning text-white mb-4 overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold mb-0">{{ $stats['active_blotters'] }}</h2>
                        <p class="mb-0">Active Blotters</p>
                    </div>
                    <i class="bx bxs-error-circle fs-1 opacity-50"></i>
                </div>
            </div>
            <a href="{{ route('blotters.index') }}" class="card-footer bg-black bg-opacity-10 text-white d-flex align-items-center justify-content-between py-2 text-decoration-none">
                <span class="small">View Details</span>
                <i class="bx bx-chevron-right small"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card bg-info text-white mb-4 overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold mb-0">{{ $stats['total_issuances'] }}</h2>
                        <p class="mb-0">Total Issuances</p>
                    </div>
                    <i class="bx bxs-file-doc fs-1 opacity-50"></i>
                </div>
            </div>
            <a href="{{ route('documents.index') }}" class="card-footer bg-black bg-opacity-10 text-white d-flex align-items-center justify-content-between py-2 text-decoration-none">
                <span class="small">View Details</span>
                <i class="bx bx-chevron-right small"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Activity</span>
                <i class="bx bx-time text-muted"></i>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Action</th>
                                <th>Entity</th>
                                <th class="pe-4">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_logs as $log)
                                <tr>
                                    <td class="ps-4 font-weight-bold">{{ $log->user->full_name ?? 'System' }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->entity_type }} #{{ $log->entity_id }}</td>
                                    <td class="pe-4 text-muted small">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent activity found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Demographics Summary</div>
            <div class="card-body">
                <canvas id="demographicsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('demographicsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Voters', 'PWD', 'Senior', '4Ps'],
                datasets: [{
                    data: [
                        {{ $stats['voters'] }}, 
                        {{ $stats['pwd'] }}, 
                        {{ $stats['senior'] }}, 
                        {{ $stats['4ps'] }}
                    ],
                    backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endpush
