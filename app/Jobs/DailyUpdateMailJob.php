<?php

namespace App\Jobs;

use App\Mail\DailyUpdateMail;
use App\Models\DailyUpdate;
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
        $tasks = DailyUpdate::with('user')->whereDate(
            'created_at',
            today()
        )->get();

        Mail::to(config('mail.admin_email'))
            ->send(new DailyUpdateMail($tasks, $tasks->first()?->user));
    }
}
