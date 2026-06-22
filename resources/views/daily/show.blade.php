@extends('layouts.app')

@section('title', 'Daily Task Details')

@section('content')
@php
    $canEdit = $task->created_at->isToday() && now()->hour < 21;
@endphp

<div class="page-header">
    <div>
        <h1 class="page-title">Daily Task Details</h1>
        <p class="page-subtitle">{{ $task->created_at->format('d M Y') }} — {{ $tasks->count() }} task(s)</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('daily.history') }}" class="btn btn-light btn-sm">Back</a>
    </div>
</div>

@foreach($tasks as $index => $dailyTask)
<div class="card mb-3">
    <div class="card-header">
        Task {{ $index + 1 }}
        @if($canEdit)
            <a href="{{ route('daily.edit', $dailyTask->id) }}" class="btn btn-warning btn-sm ms-auto">
                <i class="bi bi-pencil-fill"></i>
                Edit
            </a>
        @endif
    </div>
    <div class="card-body">
        <p><strong>Project:</strong> {{ $dailyTask->project_name ?? '—' }}</p>
        <p><strong>Task:</strong> {{ $dailyTask->task_name ?? '—' }}</p>
        <p><strong>Priority:</strong> {{ $dailyTask->priority ?? '—' }}</p>
        <p><strong>Start Date:</strong> {{ $dailyTask->start_date ?? '—' }}</p>
        <p><strong>End Date:</strong> {{ $dailyTask->end_date ?? '—' }}</p>
        <p><strong>Estimated Hours:</strong> {{ $dailyTask->estimated_hours ?? '—' }}</p>
        <p><strong>Hours Spent:</strong> {{ $dailyTask->hours_spent ?? '—' }}</p>
        <p><strong>Status:</strong> {{ $dailyTask->status ?? '—' }}</p>
        <p><strong>Progress:</strong> {{ $dailyTask->current_progress ?? '—' }}</p>
        <p><strong>Tomorrow:</strong> {{ $dailyTask->tomorrows_plan ?? '—' }}</p>
    </div>
</div>
@endforeach
@endsection
