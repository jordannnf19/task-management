<?php

namespace App\Http\Controllers;

use App\Models\DailyUpdate;
use App\Models\WeeklyUpdate;
use App\Mail\WeeklyUpdateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class WeeklyUpdateController extends Controller
{
    public function index()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $dailyUpdates = DailyUpdate::where(
                'user_id',
                Auth::id()
            )
            ->whereBetween(
                'created_at',
                [$startDate, $endDate]
            )
            ->get();

        $projects = $dailyUpdates
            ->groupBy('project_name');

        $weeklyData = [];

        foreach ($projects as $project => $tasks) {

            $weeklyData[] = [

                'project_name' => $project,

                'project_priority' =>
                    $tasks->pluck('priority')
                    ->filter()
                    ->unique()
                    ->implode(', '),

                'deadline_date' =>
                    $tasks->max('end_date'),

                'estimated_hours' =>
                    $tasks->sum('estimated_hours'),

                'actual_hours_worked' =>
                    $tasks->sum('hours_spent'),

                'activities_completed' =>
                    $tasks->pluck('task_name')
                    ->filter()
                    ->implode(', '),

                'project_status' =>
                    $tasks->pluck('status')
                    ->filter()
                    ->unique()
                    ->implode(', '),

                'plan_for_next_week' =>
                    $tasks->pluck('tomorrows_plan')
                    ->filter()
                    ->implode(', ')
            ];
        }

        $weeklyReports = WeeklyUpdate::where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();

        return view(
            'weekly.index',
            compact(
                'weeklyData',
                'weeklyReports'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reports' => ['required', 'array', 'min:1'],
            'reports.*.reporting_week' => ['required', 'string'],
            'reports.*.project_name' => ['required', 'string'],
            'reports.*.project_priority' => ['required', 'string'],
            'reports.*.deadline_date' => ['required', 'date'],
            'reports.*.estimated_hours' => ['required', 'numeric', 'min:0'],
            'reports.*.actual_hours_worked' => ['required', 'numeric', 'min:0'],
            'reports.*.activities_completed' => ['required', 'string'],
            'reports.*.issues_faced' => ['required', 'string'],
            'reports.*.project_status' => ['required', 'string'],
            'reports.*.client_feedback' => ['required', 'string'],
            'reports.*.plan_for_next_week' => ['required', 'string'],
            'reports.*.learning_update' => ['required', 'string'],
            'reports.*.key_outcomes' => ['required', 'string'],
            'reports.*.additional_notes' => ['required', 'string'],
        ]);

        foreach ($validated['reports'] as $report) {

            WeeklyUpdate::create([

                'user_id' => Auth::id(),

                'reporting_week' => $report['reporting_week'],
                'project_name' => $report['project_name'],
                'project_priority' => $report['project_priority'],
                'deadline_date' => $report['deadline_date'],
                'estimated_hours' => $report['estimated_hours'],
                'actual_hours_worked' => $report['actual_hours_worked'],
                'activities_completed' => $report['activities_completed'],
                'issues_faced' => $report['issues_faced'],
                'project_status' => $report['project_status'],
                'client_feedback' => $report['client_feedback'],
                'plan_for_next_week' => $report['plan_for_next_week'],
                'learning_update' => $report['learning_update'],
                'key_outcomes' => $report['key_outcomes'],
                'additional_notes' => $report['additional_notes'],
            ]);
        }

        return redirect()
            ->route('weekly.index')
            ->with(
                'success',
                'Weekly Report Saved Successfully.'
            );
    }

    public function edit($id)
    {
        $weekly = WeeklyUpdate::findOrFail($id);

        return view(
            'weekly.edit',
            compact('weekly')
        );
    }

    public function show($id)
    {
        $weekly = WeeklyUpdate::where('user_id', Auth::id())->findOrFail($id);

        return view('weekly.show', compact('weekly'));
    }

    public function update(
        Request $request,
        $id
    ) {
        $weekly = WeeklyUpdate::findOrFail($id);

        /*
        Prevent editing after Saturday 9 PM
        */

        if (
            now()->isSaturday()
            && now()->hour >= 21
        ) {
            return back()->with(
                'error',
                'Weekly report cannot be edited after 9 PM Saturday.'
            );
        }

        $validated = $request->validate([
            'issues_faced' => ['required', 'string'],
            'client_feedback' => ['required', 'string'],
            'learning_update' => ['required', 'string'],
            'key_outcomes' => ['required', 'string'],
            'additional_notes' => ['required', 'string'],
        ]);

        $weekly->update($validated);

        Mail::to(config('mail.admin_email'))
            ->send(new WeeklyUpdateMail(collect([$weekly]), $weekly->user));

        return redirect()
            ->route('weekly.index')
            ->with(
                'success',
                'Weekly Report Updated.'
            );
    }
}
