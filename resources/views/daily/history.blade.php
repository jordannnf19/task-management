@extends('layouts.app')

@section('title', 'Daily Task History')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Daily Task History</h1>
        <p class="page-subtitle">Submitted daily updates</p>
    </div>
    <a href="{{ route('daily.index') }}" class="btn btn-primary btn-sm">New Update</a>
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
                <tr><td colspan="6">No history found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($tasks->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $tasks->links() }}</div>
@endif
@endsection
