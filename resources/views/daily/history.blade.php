@extends('layouts.app')

@section('title', 'Daily Task History')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-clock-history text-primary" style="font-size: 22px;"></i>
            Daily Task History
        </h1>
        <p class="page-subtitle">Browse and filter all your submitted task records</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('daily.index') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            New Update
        </a>
    </div>
</div>

{{-- Filters Card --}}
<div class="card mb-4">
    <div class="card-body" style="padding: 16px 20px !important;">
        <div class="filter-row">
            <div class="input-icon-wrap" style="flex: 1; min-width: 200px; max-width: 320px;">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search project or task...">
            </div>
            <div class="input-icon-wrap">
                <i class="bi bi-funnel"></i>
                <select id="statusFilter" class="form-select" style="min-width: 150px;">
                    <option value="">All Statuses</option>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Pending">Pending</option>
                    <option value="Hold">Hold</option>
                </select>
            </div>
            <div class="input-icon-wrap">
                <i class="bi bi-flag"></i>
                <select id="priorityFilter" class="form-select" style="min-width: 140px;">
                    <option value="">All Priorities</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <button type="button" id="clearFilters" class="btn btn-light btn-sm">
                <i class="bi bi-x-circle"></i> Clear
            </button>
            <span class="ms-auto" style="font-size: 12.5px; color: var(--muted);">
                Showing <strong id="visibleCount">{{ $tasks->count() }}</strong> of {{ $tasks->total() }} records
            </span>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="tbl-wrap">
    <div class="table-responsive">
        <table class="table" id="historyTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Est. Hrs</th>
                    <th>Spent</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody id="historyBody">
                @forelse($tasks as $task)
                <tr data-status="{{ $task->status }}" data-priority="{{ $task->priority }}"
                    data-search="{{ strtolower($task->project_name . ' ' . $task->task_name) }}">

                    <td>
                        <span style="font-size: 12px; font-weight: 700; color: var(--muted);">#{{ $task->task_no }}</span>
                    </td>

                    <td>
                        <span class="badge" style="background: #F1F5F9 !important; color: var(--text) !important;">
                            <i class="bi bi-calendar3"></i>
                            {{ $task->created_at->format('d M Y') }}
                        </span>
                    </td>

                    <td>
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <div style="width: 26px; height: 26px; border-radius: 7px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-folder2 text-primary" style="font-size: 12px;"></i>
                            </div>
                            <span class="fw-500">{{ $task->project_name }}</span>
                        </div>
                    </td>

                    <td style="max-width: 200px;">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;" title="{{ $task->task_name }}">
                            {{ $task->task_name }}
                        </div>
                    </td>

                    <td>
                        @php
                            $pClass = match($task->priority) {
                                'High'   => 'badge-high',
                                'Medium' => 'badge-medium',
                                'Low'    => 'badge-low',
                                default  => 'badge-hold',
                            };
                            $pIcon = match($task->priority) {
                                'High'   => '🔴',
                                'Medium' => '🟡',
                                'Low'    => '🟢',
                                default  => '⚪',
                            };
                        @endphp
                        <span class="badge {{ $pClass }}">{{ $pIcon }} {{ $task->priority }}</span>
                    </td>

                    <td>
                        @php
                            $sClass = match($task->status) {
                                'Completed'   => 'badge-completed',
                                'In Progress' => 'badge-in-progress',
                                'Pending'     => 'badge-pending',
                                'Hold'        => 'badge-hold',
                                default       => 'badge-hold',
                            };
                        @endphp
                        <span class="badge status-badge {{ $sClass }}">{{ $task->status }}</span>
                    </td>

                    <td>
                        <span style="font-size: 13px; font-weight: 600;">{{ $task->estimated_hours ?? '—' }}h</span>
                    </td>

                    <td>
                        <span style="font-size: 13px; font-weight: 600; color: var(--primary);">{{ $task->hours_spent ?? '—' }}h</span>
                    </td>

                    <td>
                        <span class="badge" style="background: var(--primary-light) !important; color: var(--primary) !important;">
                            <i class="bi bi-clock"></i>
                            {{ $task->created_at->format('h:i A') }}
                        </span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h6>No history found</h6>
                            <p>You haven't submitted any daily updates yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($tasks->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $tasks->links() }}
</div>
@endif

@push('scripts')
<script>
(function () {
    var searchInput    = document.getElementById('searchInput');
    var statusFilter   = document.getElementById('statusFilter');
    var priorityFilter = document.getElementById('priorityFilter');
    var clearBtn       = document.getElementById('clearFilters');
    var visibleCount   = document.getElementById('visibleCount');

    function filterTable() {
        var search   = searchInput.value.toLowerCase().trim();
        var status   = statusFilter.value;
        var priority = priorityFilter.value;
        var rows     = document.querySelectorAll('#historyBody tr[data-search]');
        var visible  = 0;

        rows.forEach(function (row) {
            var matchSearch   = !search   || row.dataset.search.includes(search);
            var matchStatus   = !status   || row.dataset.status   === status;
            var matchPriority = !priority || row.dataset.priority  === priority;

            if (matchSearch && matchStatus && matchPriority) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount) visibleCount.textContent = visible;
    }

    if (searchInput)    searchInput.addEventListener('input', filterTable);
    if (statusFilter)   statusFilter.addEventListener('change', filterTable);
    if (priorityFilter) priorityFilter.addEventListener('change', filterTable);

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value    = '';
            statusFilter.value   = '';
            priorityFilter.value = '';
            filterTable();
        });
    }
})();
</script>
@endpush

@endsection
