@extends('layouts.app')

@section('title', 'My Weekly Reports')

@section('content')

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

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card" style="background: var(--primary-light) !important; border-color: #BFDBFE !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;"><i class="bi bi-file-earmark-bar-graph-fill text-primary"></i></div>
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
                <div class="stat-icon" style="background: white;"><i class="bi bi-clock-fill" style="color: var(--success);"></i></div>
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
                <div class="stat-icon" style="background: white;"><i class="bi bi-folder2-fill" style="color: var(--warning);"></i></div>
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

<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>No. of Report</th>
                    <th>Hours</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $report)
                <tr>
                    <td>{{ $report->reporting_week }}</td>
                    <td>#{{ $loop->iteration }}</td>
                    <td>{{ $report->actual_hours_worked ?? '—' }}h</td>
                    <td>{{ $report->created_at->format('d M Y h:i A') }}</td>
                    <td>
                        <a href="{{ route('weekly.show', $report->id) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-eye"></i>
                            View
                        </a>
                        <a href="{{ route('weekly.edit', $report->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
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

@if($tasks->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
    <div style="font-size: 12.5px; color: var(--muted);">
        Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} reports
    </div>
    {{ $tasks->links() }}
</div>
@endif

@endsection
