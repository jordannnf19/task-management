@extends('layouts.app')

@section('title', 'My Daily Tasks')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-calendar-check-fill text-primary" style="font-size: 22px;"></i>
            My Daily Tasks
        </h1>
        <p class="page-subtitle">Complete history of all your daily task submissions</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('my.account') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
            Back to Account
        </a>
        <a href="{{ route('daily.index') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            New Update
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card" style="background: var(--primary-light) !important; border-color: #BFDBFE !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;"><i class="bi bi-list-task text-primary"></i></div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--primary);">{{ $tasks->total() }}</div>
                    <div style="font-size: 12px; color: #1D4ED8; font-weight: 500;">Total Tasks</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="background: var(--success-light) !important; border-color: #A7F3D0 !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;"><i class="bi bi-check-circle-fill" style="color: var(--success);"></i></div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--success);">
                        {{ \App\Models\DailyUpdate::where('user_id', auth()->id())->where('status', 'Completed')->count() }}
                    </div>
                    <div style="font-size: 12px; color: #059669; font-weight: 500;">Completed</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="background: var(--warning-light) !important; border-color: #FDE68A !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;"><i class="bi bi-stopwatch-fill" style="color: var(--warning);"></i></div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: var(--warning);">
                        {{ number_format(\App\Models\DailyUpdate::where('user_id', auth()->id())->sum('hours_spent'), 1) }}h
                    </div>
                    <div style="font-size: 12px; color: #D97706; font-weight: 500;">Total Hours</div>
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
                    <th>S.No</th>
                    <th>Date</th>
                    <th>No. of Task</th>
                    <th>Hours</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $index => $task)
                <tr>
                    <td>{{ $tasks->firstItem() + $index }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->task_date)->format('d M Y') }}</td>
                    <td>{{ $task->task_count }}</td>
                    <td>{{ $task->total_hours ?? '—' }}h</td>
                    <td>{{ \Carbon\Carbon::parse($task->submitted_at)->format('h:i A') }}</td>
                    <td>
                        <a href="{{ route('daily.show', $task->first_id) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-eye"></i>
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h6>No tasks submitted yet</h6>
                            <p>Start logging your daily tasks to see them here.</p>
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
        Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
    </div>
    {{ $tasks->links() }}
</div>
@endif

@endsection
