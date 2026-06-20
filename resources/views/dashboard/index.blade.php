@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Welcome Card --}}
<div class="welcome-card">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h1 class="welcome-title">
                Welcome back, {{ explode(' ', auth()->user()->name)[0] }} 👋
            </h1>
            <p class="welcome-subtitle">Here's what's happening with your tasks today.</p>
        </div>
        <div class="welcome-date-badge">
            <i class="bi bi-calendar3"></i>
            <span id="liveDate">{{ now()->format('l, d M Y') }}</span>
            &nbsp;·&nbsp;
            <i class="bi bi-clock"></i>
            <span id="liveTime">{{ now()->format('h:i A') }}</span>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">

    {{-- Daily Updates --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body" style="padding: 24px !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background: #EFF6FF;">
                        <i class="bi bi-calendar-day-fill text-primary"></i>
                    </div>
                    <span class="badge status-badge badge-in-progress">
                        <i class="bi bi-arrow-up-short"></i> Active
                    </span>
                </div>
                <div class="stat-value" id="dailyCount">{{ $dailyCount }}</div>
                <div class="stat-label">Total Daily Updates</div>
                <div class="mt-3 pt-2" style="border-top: 1px solid var(--border);">
                    <a href="{{ route('daily.index') }}" class="text-primary fw-600" style="font-size: 12.5px; text-decoration: none;">
                        View updates <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Weekly Reports --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body" style="padding: 24px !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background: var(--success-light);">
                        <i class="bi bi-bar-chart-fill" style="color: var(--success);"></i>
                    </div>
                    <span class="badge status-badge badge-completed">
                        <i class="bi bi-check2"></i> Reports
                    </span>
                </div>
                <div class="stat-value">{{ $weeklyCount }}</div>
                <div class="stat-label">Weekly Reports Filed</div>
                <div class="mt-3 pt-2" style="border-top: 1px solid var(--border);">
                    <a href="{{ route('weekly.index') }}" style="color: var(--success); text-decoration: none; font-size: 12.5px;" class="fw-600">
                        View reports <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Current Week --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body" style="padding: 24px !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background: var(--warning-light);">
                        <i class="bi bi-clock-fill" style="color: var(--warning);"></i>
                    </div>
                    <span class="badge status-badge badge-pending">
                        <i class="bi bi-calendar-week"></i> Week
                    </span>
                </div>
                <div class="stat-value">
                    {{ now()->startOfWeek()->format('d M') }}
                </div>
                <div class="stat-label">Week of {{ now()->startOfWeek()->format('d M') }} – {{ now()->endOfWeek()->format('d M Y') }}</div>
                <div class="mt-3 pt-2" style="border-top: 1px solid var(--border);">
                    <a href="{{ route('weekly.index') }}" style="color: var(--warning); text-decoration: none; font-size: 12.5px;" class="fw-600">
                        Weekly update <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- History --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body" style="padding: 24px !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon" style="background: #F5F3FF;">
                        <i class="bi bi-archive-fill" style="color: #7C3AED;"></i>
                    </div>
                    <span class="badge status-badge" style="background: #F5F3FF !important; color: #7C3AED !important;">
                        <i class="bi bi-clock-history"></i> History
                    </span>
                </div>
                <div class="stat-value">
                    {{ \App\Models\DailyUpdate::where('user_id', auth()->id())->whereDate('created_at', today())->count() }}
                </div>
                <div class="stat-label">Tasks Logged Today</div>
                <div class="mt-3 pt-2" style="border-top: 1px solid var(--border);">
                    <a href="{{ route('daily.history') }}" style="color: #7C3AED; text-decoration: none; font-size: 12.5px;" class="fw-600">
                        View history <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Bottom row: Quick Actions + Recent Activity --}}
<div class="row g-3">

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                Quick Actions
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 10px;">

                <a href="{{ route('daily.index') }}" class="quick-action">
                    <i class="bi bi-plus-circle-fill text-primary"></i>
                    <span class="quick-action-label">Log Daily Tasks</span>
                    <span class="quick-action-sub">Submit today's work progress</span>
                </a>

                <a href="{{ route('weekly.index') }}" class="quick-action">
                    <i class="bi bi-file-earmark-bar-graph-fill" style="color: var(--success);"></i>
                    <span class="quick-action-label">Weekly Report</span>
                    <span class="quick-action-sub">File this week's summary</span>
                </a>

                <a href="{{ route('daily.history') }}" class="quick-action">
                    <i class="bi bi-clock-history" style="color: #7C3AED;"></i>
                    <span class="quick-action-label">View History</span>
                    <span class="quick-action-sub">Browse all past tasks</span>
                </a>

            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span>
                    <i class="bi bi-activity text-primary"></i>
                    Recent Activity
                </span>
                <a href="{{ route('daily.history') }}" class="btn btn-light btn-sm">
                    View all <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body" style="padding: 12px 20px !important;">

                @php
                    $recentTasks = \App\Models\DailyUpdate::where('user_id', auth()->id())
                        ->latest()->limit(6)->get();
                @endphp

                @forelse($recentTasks as $task)
                <div class="activity-item">
                    <div class="activity-dot"
                         style="background: {{ $task->status === 'Completed' ? 'var(--success)' : ($task->status === 'In Progress' ? 'var(--primary)' : 'var(--warning)') }};"></div>
                    <div class="activity-content">
                        <div class="activity-title">
                            {{ $task->task_name }}
                            <span class="badge ms-1
                                {{ $task->status === 'Completed' ? 'badge-completed' : ($task->status === 'In Progress' ? 'badge-in-progress' : ($task->status === 'Hold' ? 'badge-hold' : 'badge-pending')) }}">
                                {{ $task->status }}
                            </span>
                        </div>
                        <div class="activity-meta">
                            <i class="bi bi-folder2"></i> {{ $task->project_name }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-clock"></i> {{ $task->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="padding: 32px 16px;">
                    <i class="bi bi-inbox"></i>
                    <h6>No activity yet</h6>
                    <p>Start by logging your first daily task update.</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
// Live clock
function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    var timeStr = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
    var el = document.getElementById('liveTime');
    if (el) el.textContent = timeStr;
}
setInterval(updateClock, 1000);
updateClock();

// Animate stat values
document.querySelectorAll('.stat-value').forEach(function(el) {
    var target = parseInt(el.textContent.trim(), 10);
    if (isNaN(target) || target === 0) return;
    var current = 0;
    var step = Math.max(1, Math.ceil(target / 30));
    var timer = setInterval(function() {
        current = Math.min(current + step, target);
        el.textContent = current;
        if (current >= target) clearInterval(timer);
    }, 30);
});
</script>
@endpush

@endsection
