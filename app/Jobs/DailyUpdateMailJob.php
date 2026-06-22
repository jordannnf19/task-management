<?php

namespace App\Jobs;

use App\Mail\DailyUpdateMail;
use App\Models\DailyUpdate;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class DailyUpdateMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $users = User::orderBy('name')->get();

        foreach ($users as $user) {
            $tasks = DailyUpdate::with('user')
                ->where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->orderBy('task_no')
                ->get();

            Mail::to(config('mail.admin_email'))
                ->send(new DailyUpdateMail($tasks, $user));
        }
    }
}
