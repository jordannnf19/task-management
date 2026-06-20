@extends('layouts.app')

@section('title', 'Daily Update')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-calendar-day-fill text-primary" style="font-size: 22px;"></i>
            Daily Update
        </h1>
        <p class="page-subtitle">
            Log your tasks for
            <strong>{{ now()->format('l, d F Y') }}</strong>
        </p>
    </div>
    <div class="page-actions">
        <span class="badge status-badge badge-in-progress">
            <i class="bi bi-circle-fill" style="font-size: 7px;"></i>
            {{ now()->format('h:i A') }}
        </span>
        <a href="{{ route('daily.history') }}" class="btn btn-light btn-sm">
            <i class="bi bi-clock-history"></i> History
        </a>
    </div>
</div>

{{-- Task Form Section --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle-fill text-primary"></i>
        Add Today's Tasks
        <span class="ms-auto" style="font-size: 11.5px; color: var(--muted); font-weight: 400;">
            Fill in each task card and submit when done
        </span>
    </div>
    <div class="card-body">
        @include('daily.create')
    </div>
</div>

<hr class="section-hr">

{{-- Submitted Tasks --}}
<div class="page-header">
    <div>
        <h2 style="font-size: 16px; font-weight: 700; color: var(--text); margin: 0;">
            <i class="bi bi-table text-muted" style="font-size: 16px;"></i>
            Submitted Tasks
        </h2>
        <p class="page-subtitle">All tasks logged by you</p>
    </div>
    @if($todayTasks->count() > 0)
    <div class="page-actions">
        <span class="badge status-badge" style="background: var(--primary-light) !important; color: var(--primary) !important;">
            {{ $todayTasks->count() }} {{ Str::plural('task', $todayTasks->count()) }}
        </span>
    </div>
    @endif
</div>

<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Hours</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayTasks as $task)
                <tr>
                    <td>
                        <span style="font-size: 12px; font-weight: 700; color: var(--muted);">
                            #{{ $task->task_no }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <div style="width: 28px; height: 28px; border-radius: 7px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-folder2 text-primary" style="font-size: 13px;"></i>
                            </div>
                            <span class="fw-500">{{ $task->project_name }}</span>
                        </div>
                    </td>
                    <td style="max-width: 220px;">
                        <div style="font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px;" title="{{ $task->task_name }}">
                            {{ $task->task_name }}
                        </div>
                    </td>
                    <td>
                        @php
                            $priority = $task->priority;
                            $pClass = match($priority) {
                                'High'   => 'badge-high',
                                'Medium' => 'badge-medium',
                                'Low'    => 'badge-low',
                                default  => 'badge-hold',
                            };
                            $pIcon = match($priority) {
                                'High'   => '🔴',
                                'Medium' => '🟡',
                                'Low'    => '🟢',
                                default  => '⚪',
                            };
                        @endphp
                        <span class="badge {{ $pClass }}">{{ $pIcon }} {{ $priority }}</span>
                    </td>
                    <td>
                        @php
                            $status = $task->status;
                            $sClass = match($status) {
                                'Completed'   => 'badge-completed',
                                'In Progress' => 'badge-in-progress',
                                'Pending'     => 'badge-pending',
                                'Hold'        => 'badge-hold',
                                default       => 'badge-hold',
                            };
                        @endphp
                        <span class="badge status-badge {{ $sClass }}">{{ $status }}</span>
                    </td>
                    <td>
                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">
                            {{ $task->hours_spent ?? '—' }}h
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background: #F1F5F9 !important; color: var(--text) !important; font-size: 11.5px !important;">
                            <i class="bi bi-calendar3"></i>
                            {{ $task->created_at->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-light) !important; color: var(--primary) !important; font-size: 11.5px !important;">
                            <i class="bi bi-clock"></i>
                            {{ $task->created_at->format('h:i A') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state" style="padding: 36px 16px;">
                            <i class="bi bi-inbox"></i>
                            <h6>No tasks submitted yet</h6>
                            <p>Fill in the task cards above and click Submit Daily Update.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
