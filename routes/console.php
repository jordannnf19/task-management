<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\DailyUpdateMailJob;
use App\Jobs\WeeklyUpdateMailJob;

Schedule::job(
    new DailyUpdateMailJob
)->dailyAt('21:00');

Schedule::job(
    new WeeklyUpdateMailJob
)->weeklyOn(
    6,
    '21:00'
);