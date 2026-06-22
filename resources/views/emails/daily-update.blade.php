<h2>Daily Update Report</h2>

<p>
<b>Employee :</b>
{{ $user?->name ?? 'Employee' }}
</p>

<p>
<b>Email :</b>
{{ $user?->email ?? 'N/A' }}
</p>

@if($tasks->count())

@foreach($tasks as $task)

<hr>

<p>
<b>Task No :</b>
{{ $task->task_no ?? 'NULL' }}
</p>

<p>
<b>Project Name :</b>
{{ $task->project_name ?? 'NULL' }}
</p>

<p>
<b>Task Name :</b>
{{ $task->task_name ?? 'NULL' }}
</p>

<p>
<b>Priority :</b>
{{ $task->priority ?? 'NULL' }}
</p>

<p>
<b>Start Date :</b>
{{ $task->start_date ?? 'NULL' }}
</p>

<p>
<b>End Date :</b>
{{ $task->end_date ?? 'NULL' }}
</p>

<p>
<b>Estimated Hours :</b>
{{ $task->estimated_hours ?? 'NULL' }}
</p>

<p>
<b>Hours Spent :</b>
{{ $task->hours_spent ?? 'NULL' }}
</p>

<p>
<b>Status :</b>
{{ $task->status ?? 'NULL' }}
</p>

<p>
<b>Current Progress :</b>
{{ $task->current_progress ?? 'NULL' }}
</p>

<p>
<b>Tomorrow's Plan :</b>
{{ $task->tomorrows_plan ?? 'NULL' }}
</p>

@endforeach

@else

<p>
Today, {{ $user?->name ?? 'the employee' }} did not submit the daily update.
</p>

@endif
