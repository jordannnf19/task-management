@extends('layouts.app')

@section('title', 'Daily Update')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-calendar-day-fill text-primary" style="font-size: 22px;"></i>
            Daily Update
        </h1>
        <p class="page-subtitle">
            Log your tasks for <strong>{{ now()->format('l, d F Y') }}</strong>
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

<div class="page-header">
    <div>
        <h2 style="font-size: 16px; font-weight: 700; color: var(--text); margin: 0;">
            <i class="bi bi-table text-muted" style="font-size: 16px;"></i>
            Submitted Tasks
        </h2>
        <p class="page-subtitle">Grouped by submitted date</p>
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
                @forelse($todayTasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
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
