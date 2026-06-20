<?php

namespace App\Http\Controllers;

use App\Models\DailyUpdate;
use App\Models\WeeklyUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        foreach ($request->reports as $report) {

            WeeklyUpdate::create([

                'user_id' => Auth::id(),

                'reporting_week' =>
                    $report['reporting_week'] ?? null,

                'project_name' =>
                    $report['project_name'] ?? null,

                'project_priority' =>
                    $report['project_priority'] ?? null,

                'deadline_date' =>
                    $report['deadline_date'] ?? null,

                'estimated_hours' =>
                    $report['estimated_hours'] ?? null,

                'actual_hours_worked' =>
                    $report['actual_hours_worked'] ?? null,

                'activities_completed' =>
                    $report['activities_completed'] ?? null,

                'issues_faced' =>
                    $report['issues_faced'] ?? null,

                'project_status' =>
                    $report['project_status'] ?? null,

                'client_feedback' =>
                    $report['client_feedback'] ?? null,

                'plan_for_next_week' =>
                    $report['plan_for_next_week'] ?? null,

                'learning_update' =>
                    $report['learning_update'] ?? null,

                'key_outcomes' =>
                    $report['key_outcomes'] ?? null,

                'additional_notes' =>
                    $report['additional_notes'] ?? null,
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

        $weekly->update($request->all());

        return redirect()
            ->route('weekly.index')
            ->with(
                'success',
                'Weekly Report Updated.'
            );
    }
}