<?php

namespace App\Jobs;

use App\Mail\TaskReminderMail;
use App\Models\User;
use App\Models\WeeklyUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class WeeklyUpdateReminderJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $start = now()->startOfWeek();
        $end = now()->endOfWeek();

        User::orderBy('name')->chunk(50, function ($users) use ($start, $end) {
            foreach ($users as $user) {
                $submitted = WeeklyUpdate::where('user_id', $user->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->exists();

                if (!$submitted) {
                    Mail::to($user->email)
                        ->send(new TaskReminderMail($user, 'weekly'));
                }
            }
        });
    }
}
