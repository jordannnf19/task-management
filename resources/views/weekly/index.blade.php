@extends('layouts.app')

@section('title', 'Weekly Update')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-bar-chart-fill text-primary" style="font-size: 22px;"></i>
            Weekly Update
        </h1>
        <p class="page-subtitle">
            Week of
            <strong>{{ now()->startOfWeek()->format('d M') }} – {{ now()->endOfWeek()->format('d M Y') }}</strong>
        </p>
    </div>
    <div class="page-actions">
        <span class="week-range-badge">
            <i class="bi bi-calendar-week"></i>
            Week {{ now()->weekOfYear }}
        </span>
    </div>
</div>

{{-- Weekly Create Form --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-file-earmark-bar-graph-fill text-primary"></i>
        This Week's Report
        <span class="ms-auto" style="font-size: 11.5px; color: var(--muted); font-weight: 400;">
            Auto-filled from your daily task logs
        </span>
    </div>
    <div class="card-body">
        @include('weekly.create')
    </div>
</div>

<hr class="section-hr">

{{-- Saved Reports --}}
<div class="page-header">
    <div>
        <h2 style="font-size: 16px; font-weight: 700; color: var(--text); margin: 0;">
            <i class="bi bi-archive-fill text-muted" style="font-size: 16px;"></i>
            Saved Weekly Reports
        </h2>
        <p class="page-subtitle">All submitted reports</p>
    </div>
    @if($weeklyReports->count() > 0)
    <div class="page-actions">
        <span class="badge status-badge" style="background: var(--primary-light) !important; color: var(--primary) !important;">
            {{ $weeklyReports->count() }} {{ Str::plural('report', $weeklyReports->count()) }}
        </span>
    </div>
    @endif
</div>

<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Week</th>
                    <th>Project</th>
                    <th>Priority</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($weeklyReports as $index => $report)
                <tr>
                    <td>
                        <span style="font-size: 12px; font-weight: 700; color: var(--muted);">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-light) !important; color: var(--primary) !important; font-size: 11px !important;">
                            <i class="bi bi-calendar3"></i>
                            {{ $report->reporting_week }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <div style="width: 28px; height: 28px; border-radius: 7px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-folder2 text-primary" style="font-size: 13px;"></i>
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
                        <div>
                            <span style="font-size: 13px; font-weight: 700; color: var(--primary);">
                                {{ $report->actual_hours_worked }}h
                            </span>
                            <span style="font-size: 11px; color: var(--muted);">/ {{ $report->estimated_hours }}h est.</span>
                        </div>
                        @php
                            $pct = $report->estimated_hours > 0
                                ? min(100, round(($report->actual_hours_worked / $report->estimated_hours) * 100))
                                : 0;
                        @endphp
                        <div class="progress mt-1" style="width: 80px;">
                            <div class="progress-bar" style="width: {{ $pct }}%; background: var(--primary);"></div>
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
                    <td colspan="8">
                        <div class="empty-state" style="padding: 36px;">
                            <i class="bi bi-file-earmark-x"></i>
                            <h6>No Reports Filed</h6>
                            <p>Use the form above to file your first weekly report.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
