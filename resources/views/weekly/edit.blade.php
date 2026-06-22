@extends('layouts.app')

@section('title', 'Edit Weekly Report')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-pencil-square text-primary" style="font-size: 22px;"></i>
            Edit Weekly Report
        </h1>
        <p class="page-subtitle">
            Updating report for
            <strong>{{ $weekly->project_name }}</strong>
            &mdash;
            <span class="badge" style="background: var(--primary-light) !important; color: var(--primary) !important;">
                {{ $weekly->reporting_week }}
            </span>
        </p>
    </div>
    <div class="page-actions">
        <a href="{{ route('weekly.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
            Back to Reports
        </a>
    </div>
</div>

{{-- Edit Form --}}
<form action="{{ route('weekly.update', $weekly->id) }}" method="POST" id="editWeeklyForm">
    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- Left: Info panel --}}
        <div class="col-lg-4">
            <div class="card" style="position: sticky; top: calc(var(--nav-h) + 20px);">
                <div class="card-header">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    Report Overview
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin-bottom: 6px;">Project</div>
                        <div class="info-field">
                            <i class="bi bi-folder2 text-primary me-1"></i>
                            {{ $weekly->project_name }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin-bottom: 6px;">Reporting Week</div>
                        <div class="info-field">
                            <i class="bi bi-calendar3 text-primary me-1"></i>
                            {{ $weekly->reporting_week }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin-bottom: 6px;">Priority</div>
                        <div class="info-field">
                            @php
                                $pClass = match($weekly->project_priority) {
                                    'High'   => 'badge-high',
                                    'Medium' => 'badge-medium',
                                    'Low'    => 'badge-low',
                                    default  => 'badge-hold',
                                };
                            @endphp
                            <span class="badge {{ $pClass }}">{{ $weekly->project_priority ?: '—' }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin-bottom: 6px;">Hours</div>
                        <div class="info-field">
                            <span style="font-size: 16px; font-weight: 800; color: var(--primary);">
                                {{ $weekly->actual_hours_worked }}h
                            </span>
                            <span style="font-size: 12px; color: var(--muted);"> / {{ $weekly->estimated_hours }}h est.</span>
                        </div>
                        @php
                            $pct = $weekly->estimated_hours > 0
                                ? min(100, round(($weekly->actual_hours_worked / $weekly->estimated_hours) * 100))
                                : 0;
                        @endphp
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: {{ $pct }}%; background: var(--primary);"></div>
                        </div>
                        <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">{{ $pct }}% utilization</div>
                    </div>

                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin-bottom: 6px;">Deadline</div>
                        <div class="info-field">
                            <i class="bi bi-calendar-x text-warning me-1"></i>
                            {{ $weekly->deadline_date ? \Carbon\Carbon::parse($weekly->deadline_date)->format('d M Y') : '—' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: Edit fields --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-fill text-warning"></i>
                    Editable Fields
                    <span class="ms-1 badge editable-badge">Update as needed</span>
                </div>
                <div class="card-body" style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Issues Faced --}}
                    <div>
                        <label class="form-label">
                            <i class="bi bi-exclamation-triangle text-danger"></i>
                            Issues Faced
                        </label>
                        <textarea name="issues_faced"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Describe any blockers, challenges, or issues you encountered..."
                                  maxlength="1000"
                                  required
                                  oninput="countEdit(this, 'ife')">{{ old('issues_faced', $weekly->issues_faced) }}</textarea>
                        <div class="char-count"><span id="ife">{{ strlen($weekly->issues_faced ?? '') }}</span> / 1000</div>
                    </div>

                    {{-- Client Feedback --}}
                    <div>
                        <label class="form-label">
                            <i class="bi bi-chat-square-text text-primary"></i>
                            Client Feedback
                        </label>
                        <textarea name="client_feedback"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Any feedback, comments, or direction received from the client..."
                                  maxlength="500"
                                  required
                                  oninput="countEdit(this, 'cfe')">{{ old('client_feedback', $weekly->client_feedback) }}</textarea>
                        <div class="char-count"><span id="cfe">{{ strlen($weekly->client_feedback ?? '') }}</span> / 500</div>
                    </div>

                    {{-- Learning Update --}}
                    <div>
                        <label class="form-label">
                            <i class="bi bi-lightbulb text-warning"></i>
                            Learning Update
                        </label>
                        <textarea name="learning_update"
                                  class="form-control"
                                  rows="4"
                                  placeholder="New skills acquired, tools learned, or knowledge gained this week..."
                                  maxlength="500"
                                  required
                                  oninput="countEdit(this, 'lue')">{{ old('learning_update', $weekly->learning_update) }}</textarea>
                        <div class="char-count"><span id="lue">{{ strlen($weekly->learning_update ?? '') }}</span> / 500</div>
                    </div>

                    {{-- Key Outcomes --}}
                    <div>
                        <label class="form-label">
                            <i class="bi bi-trophy text-primary"></i>
                            Key Outcomes
                        </label>
                        <textarea name="key_outcomes"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Key deliverables or results achieved..."
                                  maxlength="500"
                                  required
                                  oninput="countEdit(this, 'koe')">{{ old('key_outcomes', $weekly->key_outcomes) }}</textarea>
                        <div class="char-count"><span id="koe">{{ strlen($weekly->key_outcomes ?? '') }}</span> / 500</div>
                    </div>

                    {{-- Additional Notes --}}
                    <div>
                        <label class="form-label">
                            <i class="bi bi-sticky text-success"></i>
                            Additional Notes
                        </label>
                        <textarea name="additional_notes"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Any other relevant notes, observations, or comments..."
                                  maxlength="500"
                                  required
                                  oninput="countEdit(this, 'ane')">{{ old('additional_notes', $weekly->additional_notes) }}</textarea>
                        <div class="char-count"><span id="ane">{{ strlen($weekly->additional_notes ?? '') }}</span> / 500</div>
                    </div>

                </div>
            </div>

            {{-- Sticky Save --}}
            <div class="sticky-save-bar">
                <div class="sticky-save-inner">
                    <div style="font-size: 12.5px; color: var(--muted);">
                        <i class="bi bi-info-circle me-1"></i>
                        Edits locked after Saturday 9 PM
                    </div>
                    <a href="{{ route('weekly.index') }}" class="btn btn-light btn-sm">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success" id="saveEditBtn">
                        <i class="bi bi-check-lg"></i>
                        Update Report
                    </button>
                </div>
            </div>
        </div>

    </div>

</form>

@push('scripts')
<script>
function countEdit(el, id) {
    var c = document.getElementById(id);
    if (c) c.textContent = el.value.length;
}

document.getElementById('editWeeklyForm').addEventListener('submit', function () {
    var btn = document.getElementById('saveEditBtn');
    if (btn) {
        btn.innerHTML = '<span style="display:inline-block; animation: spin 0.7s linear infinite;">↻</span> Saving...';
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.8';
    }
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@endsection
