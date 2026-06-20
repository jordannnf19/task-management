<?php

namespace App\Http\Controllers;

use App\Models\DailyUpdate;
use App\Models\WeeklyUpdate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dailyCount = DailyUpdate::where(
            'user_id',
            Auth::id()
        )->count();

        $weeklyCount = WeeklyUpdate::where(
            'user_id',
            Auth::id()
        )->count();

        return view(
            'dashboard.index',
            compact(
                'dailyCount',
                'weeklyCount'
            )
        );
    }

    public function myAccount()
    {
        return view('my-account.index');
    }

    public function myDailyTasks()
    {
        $tasks = DailyUpdate::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->paginate(10);

        return view(
            'my-account.daily',
            compact('tasks')
        );
    }

    public function myWeeklyTasks()
    {
        $tasks = WeeklyUpdate::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->paginate(10);

        return view(
            'my-account.weekly',
            compact('tasks')
        );
    }
}