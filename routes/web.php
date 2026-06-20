<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyUpdateController;
use App\Http\Controllers\WeeklyUpdateController;

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Daily Updates
    |--------------------------------------------------------------------------
    */

    Route::get('/daily-updates',
        [DailyUpdateController::class, 'index'])
        ->name('daily.index');

    Route::post('/daily-updates/store',
        [DailyUpdateController::class, 'store'])
        ->name('daily.store');

    Route::get('/daily-updates/history',
        [DailyUpdateController::class, 'history'])
        ->name('daily.history');

    /*
    |--------------------------------------------------------------------------
    | Weekly Updates
    |--------------------------------------------------------------------------
    */

    Route::get('/weekly-updates',
        [WeeklyUpdateController::class, 'index'])
        ->name('weekly.index');

    Route::post('/weekly-updates/store',
        [WeeklyUpdateController::class, 'store'])
        ->name('weekly.store');

    Route::get('/weekly-updates/edit/{id}',
        [WeeklyUpdateController::class, 'edit'])
        ->name('weekly.edit');

    /*
    |--------------------------------------------------------------------------
    | My Account
    |--------------------------------------------------------------------------
    */

    Route::get('/my-account',
        [DashboardController::class, 'myAccount'])
        ->name('my.account');

    Route::get('/my-daily-tasks',
        [DashboardController::class, 'myDailyTasks'])
        ->name('my.daily.tasks');

    Route::get('/my-weekly-tasks',
        [DashboardController::class, 'myWeeklyTasks'])
        ->name('my.weekly.tasks');
});