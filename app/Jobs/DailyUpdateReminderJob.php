<?php

namespace App\Jobs;

use App\Mail\TaskReminderMail;
use App\Models\DailyUpdate;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class DailyUpdateReminderJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        User::orderBy('name')->chunk(50, function ($users) {
            foreach ($users as $user) {
                $submitted = DailyUpdate::where('user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->exists();

                if (!$submitted) {
                    Mail::to($user->email)
                        ->send(new TaskReminderMail($user, 'daily'));
                }
            }
        });
    }
}
