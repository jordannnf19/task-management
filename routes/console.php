<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\DailyUpdateMailJob;
use App\Jobs\DailyUpdateReminderJob;
use App\Jobs\WeeklyUpdateMailJob;
use App\Jobs\WeeklyUpdateReminderJob;





Schedule::job(
    new DailyUpdateReminderJob
)->dailyAt('21:00')->timezone('Asia/Kolkata');

Schedule::job(
    new DailyUpdateMailJob
)->dailyAt('22:00')->timezone('Asia/Kolkata');





Schedule::job(
    new WeeklyUpdateReminderJob
)->weeklyOn(
    6,
    '21:00'
)->timezone('Asia/Kolkata');

Schedule::job(
    new WeeklyUpdateMailJob
)->weeklyOn(
    6,
    '22:00'
)->timezone('Asia/Kolkata');
