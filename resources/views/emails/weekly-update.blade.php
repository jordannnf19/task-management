<h2>Weekly Update Report</h2>

@if($reports->count())

@foreach($reports as $report)

<hr>

<p>
<b>Reporting Week :</b>
{{ $report->reporting_week ?? 'NULL' }}
</p>

<p>
<b>Project Name :</b>
{{ $report->project_name ?? 'NULL' }}
</p>

<p>
<b>Priority :</b>
{{ $report->project_priority ?? 'NULL' }}
</p>

<p>
<b>Estimated Hours :</b>
{{ $report->estimated_hours ?? 'NULL' }}
</p>

<p>
<b>Actual Hours Worked :</b>
{{ $report->actual_hours_worked ?? 'NULL' }}
</p>

<p>
<b>Activities :</b>
{{ $report->activities_completed ?? 'NULL' }}
</p>

<p>
<b>Issues :</b>
{{ $report->issues_faced ?? 'NULL' }}
</p>

<p>
<b>Client Feedback :</b>
{{ $report->client_feedback ?? 'NULL' }}
</p>

<p>
<b>Plan For Next Week :</b>
{{ $report->plan_for_next_week ?? 'NULL' }}
</p>

@endforeach

@else

<p>
This week, {{ $user?->name ?? 'the employee' }} did not submit the weekly update.
</p>

@endif
