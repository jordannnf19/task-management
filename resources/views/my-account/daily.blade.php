@extends('layouts.app')

@section('title', 'My Daily Tasks')

@section('content')

{{-- Page Header --}}
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

{{-- Summary row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card" style="background: var(--primary-light) !important; border-color: #BFDBFE !important;">
            <div class="card-body" style="padding: 16px 20px !important; display: flex; align-items: center; gap: 12px;">
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-list-task text-primary"></i>
                </div>
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
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-check-circle-fill" style="color: var(--success);"></i>
                </div>
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
                <div class="stat-icon" style="background: white;">
                    <i class="bi bi-stopwatch-fill" style="color: var(--warning);"></i>
                </div>
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

{{-- Table --}}
<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Est. Hrs</th>
                    <th>Spent</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>
                        <span style="font-size: 12px; font-weight: 700; color: var(--muted);">#{{ $task->task_no }}</span>
                    </td>
                    <td>
                        <span class="badge" style="background: #F1F5F9 !important; color: var(--text) !important;">
                            <i class="bi bi-calendar3"></i>
                            {{ $task->created_at->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <div style="width: 26px; height: 26px; border-radius: 7px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-folder2 text-primary" style="font-size: 12px;"></i>
                            </div>
                            <span class="fw-500">{{ $task->project_name }}</span>
                        </div>
                    </td>
                    <td style="max-width: 200px;">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;" title="{{ $task->task_name }}">
                            {{ $task->task_name }}
                        </div>
                    </td>
                    <td>
                        @php
                            $pClass = match($task->priority) {
                                'High'   => 'badge-high',
                                'Medium' => 'badge-medium',
                                'Low'    => 'badge-low',
                                default  => 'badge-hold',
                            };
                            $pIcon = match($task->priority) {
                                'High'   => '🔴',
                                'Medium' => '🟡',
                                'Low'    => '🟢',
                                default  => '⚪',
                            };
                        @endphp
                        <span class="badge {{ $pClass }}">{{ $pIcon }} {{ $task->priority }}</span>
                    </td>
                    <td>
                        @php
                            $sClass = match($task->status) {
                                'Completed'   => 'badge-completed',
                                'In Progress' => 'badge-in-progress',
                                'Pending'     => 'badge-pending',
                                'Hold'        => 'badge-hold',
                                default       => 'badge-hold',
                            };
                        @endphp
                        <span class="badge status-badge {{ $sClass }}">{{ $task->status }}</span>
                    </td>
                    <td>
                        <span style="font-size: 13px; font-weight: 600; color: var(--muted);">{{ $task->estimated_hours ?? '—' }}h</span>
                    </td>
                    <td>
                        <span style="font-size: 13px; font-weight: 700; color: var(--primary);">{{ $task->hours_spent ?? '—' }}h</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
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

{{-- Pagination --}}
@if($tasks->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
    <div style="font-size: 12.5px; color: var(--muted);">
        Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
    </div>
    {{ $tasks->links() }}
</div>
@endif

@endsection
