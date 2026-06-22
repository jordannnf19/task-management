@extends('layouts.app')

@section('title', 'Weekly Report Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Weekly Report Details</h1>
        <p class="page-subtitle">{{ $weekly->reporting_week }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('weekly.edit', $weekly->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <a href="{{ route('weekly.index') }}" class="btn btn-light btn-sm">Back</a>
    </div>
</div>

<div class="card"><div class="card-body">
@foreach([
    'Project Name' => $weekly->project_name,
    'Priority' => $weekly->project_priority,
    'Deadline' => $weekly->deadline_date,
    'Estimated Hours' => $weekly->estimated_hours,
    'Actual Hours Worked' => $weekly->actual_hours_worked,
    'Activities Completed' => $weekly->activities_completed,
    'Issues Faced' => $weekly->issues_faced,
    'Project Status' => $weekly->project_status,
    'Client Feedback' => $weekly->client_feedback,
    'Plan For Next Week' => $weekly->plan_for_next_week,
    'Learning Update' => $weekly->learning_update,
    'Key Outcomes' => $weekly->key_outcomes,
    'Additional Notes' => $weekly->additional_notes,
] as $label => $value)
    <p><strong>{{ $label }}:</strong> {{ $value ?? '—' }}</p>
@endforeach
</div></div>
@endsection
