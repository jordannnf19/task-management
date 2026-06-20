<?php

namespace App\Http\Controllers;

use App\Models\DailyUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyUpdateController extends Controller
{
    public function index()
    {
        $todayTasks = DailyUpdate::where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();

        return view(
            'daily.index',
            compact('todayTasks')
        );
    }

    public function store(Request $request)
    {
        $tasks = $request->tasks;

        if (!$tasks) {
            return back()->with(
                'error',
                'Please add at least one task.'
            );
        }

        foreach ($tasks as $index => $task) {

            DailyUpdate::create([

                'user_id' => Auth::id(),
                'task_no' => $index + 1,

                'project_name' =>
                    $task['project_name'] ?? null,

                'task_name' =>
                    $task['task_name'] ?? null,

                'priority' =>
                    $task['priority'] ?? null,

                'start_date' =>
                    $task['start_date'] ?? null,

                'end_date' =>
                    $task['end_date'] ?? null,

                'estimated_hours' =>
                    $task['estimated_hours'] ?? null,

                'hours_spent' =>
                    $task['hours_spent'] ?? null,

                'status' =>
                    $task['status'] ?? null,

                'current_progress' =>
                    $task['current_progress'] ?? null,

                'tomorrows_plan' =>
                    $task['tomorrows_plan'] ?? null,
            ]);
        }

        return redirect()
            ->route('daily.index')
            ->with(
                'success',
                'Daily Tasks Submitted Successfully.'
            );
    }

    public function history()
    {
        $tasks = DailyUpdate::where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(20);

        return view(
            'daily.history',
            compact('tasks')
        );
    }
}