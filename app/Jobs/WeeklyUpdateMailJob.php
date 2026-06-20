<?php

namespace App\Jobs;

use App\Mail\WeeklyUpdateMail;
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
        $reports = WeeklyUpdate::with('user')->whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->get();

        Mail::to(config('mail.admin_email'))
            ->send(new WeeklyUpdateMail($reports, $reports->first()?->user));
    }
}
