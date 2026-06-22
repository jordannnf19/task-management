@extends('layouts.app')

@section('title', 'Edit Daily Task')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Daily Task</h1>
        <p class="page-subtitle">Editable until 9 PM</p>
    </div>
    <a href="{{ route('daily.show', $task->id) }}" class="btn btn-light btn-sm">Back</a>
</div>

<form action="{{ route('daily.update', $task->id) }}" method="POST" class="card">
    @csrf
    @method('PUT')
    <div class="card-body row g-3">
        <div class="col-md-6"><label class="form-label">Project Name</label><input class="form-control" name="project_name" value="{{ old('project_name', $task->project_name) }}" required></div>
        <div class="col-md-6"><label class="form-label">Task Name</label><input class="form-control" name="task_name" value="{{ old('task_name', $task->task_name) }}" required></div>
        <div class="col-md-4"><label class="form-label">Priority</label><select class="form-select" name="priority" required>@foreach(['High','Medium','Low'] as $v)<option value="{{ $v }}" @selected(old('priority', $task->priority) === $v)>{{ $v }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Start Date</label><input type="date" class="form-control" name="start_date" value="{{ old('start_date', $task->start_date) }}" required></div>
        <div class="col-md-4"><label class="form-label">End Date</label><input type="date" class="form-control" name="end_date" value="{{ old('end_date', $task->end_date) }}" required></div>
        <div class="col-md-3"><label class="form-label">Estimated Hours</label><input type="number" step="0.5" min="0" class="form-control" name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours) }}" required></div>
        <div class="col-md-3"><label class="form-label">Hours Spent</label><input type="number" step="0.5" min="0" class="form-control" name="hours_spent" value="{{ old('hours_spent', $task->hours_spent) }}" required></div>
        <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status" required>@foreach(['Completed','In Progress','Pending','Hold'] as $v)<option value="{{ $v }}" @selected(old('status', $task->status) === $v)>{{ $v }}</option>@endforeach</select></div>
        <div class="col-12"><label class="form-label">Current Progress</label><textarea class="form-control" rows="4" name="current_progress" required>{{ old('current_progress', $task->current_progress) }}</textarea></div>
        <div class="col-12"><label class="form-label">Tomorrow's Plan</label><textarea class="form-control" rows="4" name="tomorrows_plan" required>{{ old('tomorrows_plan', $task->tomorrows_plan) }}</textarea></div>
        <div class="col-12"><button class="btn btn-success">Update Task</button></div>
    </div>
</form>
@endsection
