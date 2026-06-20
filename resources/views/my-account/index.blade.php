@extends('layouts.app')

@section('title', 'My Account')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-person-circle text-primary" style="font-size: 22px;"></i>
            My Account
        </h1>
        <p class="page-subtitle">Your profile and task statistics</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('my.daily.tasks') }}" class="btn btn-light btn-sm">
            <i class="bi bi-calendar-check"></i>
            My Daily Tasks
        </a>
        <a href="{{ route('my.weekly.tasks') }}" class="btn btn-light btn-sm">
            <i class="bi bi-bar-chart"></i>
            My Weekly Reports
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center" style="padding: 32px 24px !important;">

                <div class="profile-avatar-lg mx-auto mb-3">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin: 0 0 4px;">
                    {{ auth()->user()->name }}
                </h3>
                <p style="font-size: 13px; color: var(--muted); margin: 0 0 16px;">
                    <i class="bi bi-envelope me-1"></i>
                    {{ auth()->user()->email }}
                </p>

                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge status-badge badge-completed">
                        <i class="bi bi-circle-fill" style="font-size: 7px;"></i>
                        Active
                    </span>
                    <span class="badge" style="background: #F5F3FF !important; color: #7C3AED !important;">
                        <i class="bi bi-person-check"></i>
                        Member
                    </span>
                </div>

                <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 10px; padding: 14px;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--muted); margin-bottom: 8px;">
                        Member Since
                    </div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--text);">
                        <i class="bi bi-calendar3 text-primary me-1"></i>
                        {{ auth()->user()->created_at->format('d M Y') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="col-lg-8">
        <div class="row g-3">

            {{-- Daily Count --}}
            @php
                $dailyCount  = \App\Models\DailyUpdate::where('user_id', auth()->id())->count();
                $weeklyCount = \App\Models\WeeklyUpdate::where('user_id', auth()->id())->count();
                $todayCount  = \App\Models\DailyUpdate::where('user_id', auth()->id())->whereDate('created_at', today())->count();
                $totalHours  = \App\Models\DailyUpdate::where('user_id', auth()->id())->sum('hours_spent');
            @endphp

            <div class="col-sm-6">
                <div class="card stat-card">
                    <div class="card-body" style="padding: 22px !important;">
                        <div class="stat-icon mb-3" style="background: var(--primary-light);">
                            <i class="bi bi-calendar-day-fill text-primary"></i>
                        </div>
                        <div class="stat-value">{{ $dailyCount }}</div>
                        <div class="stat-label">Daily Updates Submitted</div>
                        <div class="mt-3">
                            <a href="{{ route('my.daily.tasks') }}" style="font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 600;">
                                View all <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card stat-card">
                    <div class="card-body" style="padding: 22px !important;">
                        <div class="stat-icon mb-3" style="background: var(--success-light);">
                            <i class="bi bi-bar-chart-fill" style="color: var(--success);"></i>
                        </div>
                        <div class="stat-value">{{ $weeklyCount }}</div>
                        <div class="stat-label">Weekly Reports Filed</div>
                        <div class="mt-3">
                            <a href="{{ route('my.weekly.tasks') }}" style="font-size: 12px; color: var(--success); text-decoration: none; font-weight: 600;">
                                View all <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card stat-card">
                    <div class="card-body" style="padding: 22px !important;">
                        <div class="stat-icon mb-3" style="background: var(--warning-light);">
                            <i class="bi bi-clock-fill" style="color: var(--warning);"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalHours, 1) }}h</div>
                        <div class="stat-label">Total Hours Logged</div>
                        <div class="mt-3">
                            <span style="font-size: 12px; color: var(--muted);">Across all tasks</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card stat-card">
                    <div class="card-body" style="padding: 22px !important;">
                        <div class="stat-icon mb-3" style="background: #F5F3FF;">
                            <i class="bi bi-check-circle-fill" style="color: #7C3AED;"></i>
                        </div>
                        <div class="stat-value">{{ $todayCount }}</div>
                        <div class="stat-label">Tasks Logged Today</div>
                        <div class="mt-3">
                            <a href="{{ route('daily.index') }}" style="font-size: 12px; color: #7C3AED; text-decoration: none; font-weight: 600;">
                                Add more <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Quick navigation links --}}
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-grid text-primary"></i>
                Quick Navigation
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <a href="{{ route('dashboard') }}" class="quick-action">
                            <i class="bi bi-grid-1x2-fill text-primary"></i>
                            <span class="quick-action-label">Dashboard</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="{{ route('daily.index') }}" class="quick-action">
                            <i class="bi bi-calendar-day-fill text-primary"></i>
                            <span class="quick-action-label">Daily Update</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="{{ route('weekly.index') }}" class="quick-action">
                            <i class="bi bi-bar-chart-fill" style="color: var(--success);"></i>
                            <span class="quick-action-label">Weekly Update</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="{{ route('daily.history') }}" class="quick-action">
                            <i class="bi bi-clock-history" style="color: #7C3AED;"></i>
                            <span class="quick-action-label">Task History</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
