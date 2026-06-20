@extends('layouts.app')

@section('title', 'My Weekly Reports')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-bar-chart-line-fill text-primary" style="font-size: 22px;"></i>
            My Weekly Reports
        </h1>
        <p class="page-subtitle">All weekly reports you have submitted</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('my.account') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
            Back to Account
        </a>
        <a href="{{ route('weekly.index') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            New Report
        </a>
    </div>
</div>

{{-- Summary row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card" style="background: var(--primary-light) !important; border-color: #BFDBFE !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-file-earmark-bar-graph-fill text-primary"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--primary);">{{ $tasks->total() }}</div>
                    <div style="font-size: 12px; color: #1D4ED8; font-weight: 500;">Total Reports</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="background: var(--success-light) !important; border-color: #A7F3D0 !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-clock-fill" style="color: var(--success);"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--success);">
                        {{ number_format(\App\Models\WeeklyUpdate::where('user_id', auth()->id())->sum('actual_hours_worked'), 1) }}h
                    </div>
                    <div style="font-size: 12px; color: #059669; font-weight: 500;">Total Hours</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="background: var(--warning-light) !important; border-color: #FDE68A !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-folder2-fill" style="color: var(--warning);"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--warning);">
                        {{ \App\Models\WeeklyUpdate::where('user_id', auth()->id())->distinct('project_name')->count('project_name') }}
                    </div>
                    <div style="font-size: 12px; color: #D97706; font-weight: 500;">Projects</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Week</th>
                    <th>Project</th>
                    <th>Priority</th>
                    <th>Est. Hrs</th>
                    <th>Actual Hrs</th>
                    <th>Utilization</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $report)
                <tr>
                    <td>
                        <span style="font-size: 12px; font-weight: 700; color: var(--muted);">{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-light) !important; color: var(--primary) !important; font-size: 11px !important;">
                            <i class="bi bi-calendar3"></i>
                            {{ $report->reporting_week }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <div style="width: 26px; height: 26px; border-radius: 7px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-folder2 text-primary" style="font-size: 12px;"></i>
                            </div>
                            <span class="fw-500">{{ $report->project_name }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $pClass = match($report->project_priority) {
                                'High'   => 'badge-high',
                                'Medium' => 'badge-medium',
                                'Low'    => 'badge-low',
                                default  => 'badge-hold',
                            };
                        @endphp
                        <span class="badge {{ $pClass }}">{{ $report->project_priority ?: '—' }}</span>
                    </td>
                    <td>
                        <span style="font-size: 13px; font-weight: 600; color: var(--muted);">
                            {{ $report->estimated_hours }}h
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 13px; font-weight: 700; color: var(--primary);">
                            {{ $report->actual_hours_worked }}h
                        </span>
                    </td>
                    <td style="min-width: 100px;">
                        @php
                            $pct = $report->estimated_hours > 0
                                ? min(100, round(($report->actual_hours_worked / $report->estimated_hours) * 100))
                                : 0;
                            $barColor = $pct > 100 ? 'var(--danger)' : ($pct >= 80 ? 'var(--success)' : 'var(--warning)');
                        @endphp
                        <div style="font-size: 11.5px; font-weight: 700; color: var(--text); margin-bottom: 3px;">{{ $pct }}%</div>
                        <div class="progress" style="width: 80px;">
                            <div class="progress-bar" style="width: {{ $pct }}%; background: {{ $barColor }};"></div>
                        </div>
                    </td>
                    <td>
                        @php
                            $sClass = match($report->project_status) {
                                'Completed' => 'badge-completed',
                                'On Track'  => 'badge-in-progress',
                                'Delayed'   => 'badge-pending',
                                'At Risk'   => 'badge-high',
                                'On Hold'   => 'badge-hold',
                                default     => 'badge-hold',
                            };
                        @endphp
                        <span class="badge status-badge {{ $sClass }}">{{ $report->project_status }}</span>
                    </td>
                    <td>
                        <span style="font-size: 12px; color: var(--muted);">
                            {{ $report->created_at->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('weekly.edit', $report->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <i class="bi bi-file-earmark-x"></i>
                            <h6>No weekly reports yet</h6>
                            <p>File your first weekly report to track project progress.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($tasks->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
    <div style="font-size: 12.5px; color: var(--muted);">
        Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} reports
    </div>
    {{ $tasks->links() }}
</div>
@endif

@endsection
