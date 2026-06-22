<?php

namespace App\Jobs;

use App\Mail\WeeklyUpdateMail;
use App\Models\DailyUpdate;
use App\Models\WeeklyUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class WeeklyUpdateMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $reportingWeek = $weekStart->format('d M').' to '.$weekEnd->format('d M Y');

        DailyUpdate::query()
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get()
            ->groupBy(fn (DailyUpdate $task) => $task->user_id.'|'.$task->project_name)
            ->each(function ($tasks) use ($reportingWeek) {
                $firstTask = $tasks->first();

                WeeklyUpdate::firstOrCreate(
                    [
                        'user_id' => $firstTask->user_id,
                        'reporting_week' => $reportingWeek,
                        'project_name' => $firstTask->project_name,
                    ],
                    [
                        'project_priority' => $tasks->pluck('priority')->filter()->unique()->implode(', '),
                        'deadline_date' => $tasks->max('end_date'),
                        'estimated_hours' => $tasks->sum('estimated_hours'),
                        'actual_hours_worked' => $tasks->sum('hours_spent'),
                        'activities_completed' => $tasks->pluck('task_name')->filter()->implode(', '),
                        'project_status' => $tasks->pluck('status')->filter()->unique()->implode(', '),
                        'plan_for_next_week' => $tasks->pluck('tomorrows_plan')->filter()->implode(', '),
                    ]
                );
            });

        $reports = WeeklyUpdate::with('user')->whereBetween(
            'created_at',
            [
                $weekStart,
                $weekEnd
            ]
        )->get();

        Mail::to(config('mail.admin_email'))
            ->send(new WeeklyUpdateMail($reports, $reports->first()?->user));
    }
}
