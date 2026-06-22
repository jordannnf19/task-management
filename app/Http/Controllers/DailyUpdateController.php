<?php

namespace App\Http\Controllers;

use App\Mail\DailyUpdateMail;
use App\Models\DailyUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DailyUpdateController extends Controller
{
    public function index()
    {
        $todayTasks = DailyUpdate::where(
                'user_id',
                Auth::id()
            )
            ->selectRaw('DATE(created_at) as task_date, MIN(id) as first_id, COUNT(*) as task_count, SUM(hours_spent) as total_hours, MIN(created_at) as submitted_at')
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('task_date')
            ->get();

        return view(
            'daily.index',
            compact('todayTasks')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks' => ['required', 'array', 'min:1'],
            'tasks.*.project_name' => ['required', 'string'],
            'tasks.*.task_name' => ['required', 'string'],
            'tasks.*.priority' => ['required', 'string'],
            'tasks.*.start_date' => ['required', 'date'],
            'tasks.*.end_date' => ['required', 'date'],
            'tasks.*.estimated_hours' => ['required', 'numeric', 'min:0'],
            'tasks.*.hours_spent' => ['required', 'numeric', 'min:0'],
            'tasks.*.status' => ['required', 'string'],
            'tasks.*.current_progress' => ['required', 'string'],
            'tasks.*.tomorrows_plan' => ['required', 'string'],
        ]);

        foreach ($validated['tasks'] as $index => $task) {

            DailyUpdate::create([

                'user_id' => Auth::id(),
                'task_no' => $index + 1,

                'project_name' => $task['project_name'],
                'task_name' => $task['task_name'],
                'priority' => $task['priority'],
                'start_date' => $task['start_date'],
                'end_date' => $task['end_date'],
                'estimated_hours' => $task['estimated_hours'],
                'hours_spent' => $task['hours_spent'],
                'status' => $task['status'],
                'current_progress' => $task['current_progress'],
                'tomorrows_plan' => $task['tomorrows_plan'],
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
            ->selectRaw('DATE(created_at) as task_date, MIN(id) as first_id, COUNT(*) as task_count, SUM(hours_spent) as total_hours, MIN(created_at) as submitted_at')
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('task_date')
            ->paginate(20);

        return view(
            'daily.history',
            compact('tasks')
        );
    }

    public function show($id)
    {
        $task = DailyUpdate::where('user_id', Auth::id())->findOrFail($id);
        $tasks = DailyUpdate::where('user_id', Auth::id())
            ->whereDate('created_at', $task->created_at->toDateString())
            ->orderBy('task_no')
            ->get();

        return view('daily.show', compact('task', 'tasks'));
    }

    public function edit($id)
    {
        $task = DailyUpdate::where('user_id', Auth::id())->findOrFail($id);

        abort_if(
            now()->hour >= 21 || !$task->created_at->isToday(),
            403,
            'Only today daily updates are editable before 9 PM.'
        );

        return view('daily.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = DailyUpdate::where('user_id', Auth::id())->findOrFail($id);

        abort_if(
            now()->hour >= 21 || !$task->created_at->isToday(),
            403,
            'Only today daily updates are editable before 9 PM.'
        );

        $validated = $request->validate([
            'project_name' => ['required', 'string'],
            'task_name' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'estimated_hours' => ['required', 'numeric', 'min:0'],
            'hours_spent' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string'],
            'current_progress' => ['required', 'string'],
            'tomorrows_plan' => ['required', 'string'],
        ]);

        $task->update($validated);

        return redirect()->route('daily.show', $task)->with('success', 'Daily task updated.');
    }

    public function sendEmail()
    {
        abort_if(now()->hour >= 21, 403, 'Daily updates are sent automatically after 9 PM.');

        $tasks = DailyUpdate::with('user')
            ->where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->get();

        if ($tasks->isEmpty() || $tasks->contains(function ($task) {
            return collect([
                $task->project_name,
                $task->task_name,
                $task->priority,
                $task->start_date,
                $task->end_date,
                $task->estimated_hours,
                $task->hours_spent,
                $task->status,
                $task->current_progress,
                $task->tomorrows_plan,
            ])->contains(fn ($value) => $value === null || $value === '');
        })) {
            return back()->with('error', 'Please fill all daily update fields before sending email.');
        }

        Mail::to(config('mail.admin_email'))
            ->send(new DailyUpdateMail($tasks, Auth::user()));

        return back()->with('success', 'Daily update email sent.');
    }
}
