<form action="{{ route('weekly.store') }}" method="POST" id="weeklyForm">
@csrf

@if(count($weeklyData) === 0)

<div class="empty-state" style="padding: 40px 20px;">
    <i class="bi bi-calendar-x" style="font-size: 44px; color: #CBD5E1; display: block; margin-bottom: 14px;"></i>
    <h6 style="font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 4px;">No Daily Tasks This Week</h6>
    <p style="font-size: 13px; color: var(--muted); margin: 0 0 16px;">
        Log daily updates this week to auto-generate your weekly report.
    </p>
    <a href="{{ route('daily.index') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Add Daily Tasks First
    </a>
</div>

@else

{{-- Week header --}}
<div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background: var(--primary-light); border: 1px solid #BFDBFE;">
    <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 18px; flex-shrink: 0;">
        <i class="bi bi-calendar-week"></i>
    </div>
    <div style="flex: 1;">
        <div style="font-size: 13px; font-weight: 700; color: var(--text);">Reporting Week</div>
        <div class="week-range-badge mt-1">
            <i class="bi bi-calendar3"></i>
            {{ now()->startOfWeek()->format('d M') }} – {{ now()->endOfWeek()->format('d M Y') }}
        </div>
    </div>
    <div style="font-size: 12px; color: var(--muted);">
        {{ count($weeklyData) }} {{ Str::plural('project', count($weeklyData)) }} detected
    </div>
</div>

{{-- Project cards --}}
@foreach($weeklyData as $key => $week)

<div class="weekly-proj-card">

    {{-- Project header --}}
    <div class="weekly-proj-header">
        <div class="proj-icon">
            <i class="bi bi-folder2-open"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 13px; font-weight: 700; color: var(--text);">
                {{ $week['project_name'] }}
            </div>
            <div style="font-size: 11.5px; color: var(--muted);">
                Priority: {{ $week['project_priority'] ?: '—' }}
                &nbsp;·&nbsp;
                Est. {{ $week['estimated_hours'] }}h
                &nbsp;·&nbsp;
                Spent {{ $week['actual_hours_worked'] }}h
            </div>
        </div>
        <span class="week-range-badge">
            <i class="bi bi-clock"></i>
            {{ $week['actual_hours_worked'] }}h logged
        </span>
    </div>

    {{-- Hidden reporting_week --}}
    <input type="hidden"
           name="reports[{{ $key }}][reporting_week]"
           value="{{ now()->startOfWeek()->format('d M') }} to {{ now()->endOfWeek()->format('d M Y') }}">

    <div style="padding: 0 20px;">

        {{-- Auto-filled section --}}
        <div class="field-section">
            <div class="field-section-title">
                <i class="bi bi-lock-fill" style="font-size: 11px;"></i>
                Auto-Filled from Daily Logs
                <span class="autofilled-badge">READ-ONLY</span>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Project Name</label>
                    <input type="text" class="form-control readonly-field"
                           name="reports[{{ $key }}][project_name]"
                           value="{{ $week['project_name'] }}" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Priority</label>
                    <input type="text" class="form-control readonly-field"
                           name="reports[{{ $key }}][project_priority]"
                           value="{{ $week['project_priority'] }}" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" class="form-control readonly-field"
                           name="reports[{{ $key }}][deadline_date]"
                           value="{{ $week['deadline_date'] }}" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Est. Hours</label>
                    <input type="number" step="0.01" class="form-control readonly-field"
                           name="reports[{{ $key }}][estimated_hours]"
                           value="{{ $week['estimated_hours'] }}" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hours Worked</label>
                    <input type="number" step="0.01" class="form-control readonly-field"
                           name="reports[{{ $key }}][actual_hours_worked]"
                           value="{{ $week['actual_hours_worked'] }}" readonly required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Activities Completed</label>
                    <textarea class="form-control readonly-field" rows="3"
                              name="reports[{{ $key }}][activities_completed]" readonly required>{{ $week['activities_completed'] }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Plan for Next Week</label>
                    <textarea class="form-control readonly-field" rows="3"
                              name="reports[{{ $key }}][plan_for_next_week]" readonly required>{{ $week['plan_for_next_week'] }}</textarea>
                </div>
            </div>
        </div>

        {{-- Editable section --}}
        <div class="field-section">
            <div class="field-section-title">
                <i class="bi bi-pencil-square" style="font-size: 11px; color: var(--primary);"></i>
                <span style="color: var(--primary);">Your Input Required</span>
                <span class="editable-badge">EDITABLE</span>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-exclamation-triangle"></i>
                        Issues Faced
                    </label>
                    <textarea class="form-control" rows="3"
                              name="reports[{{ $key }}][issues_faced]"
                              placeholder="Describe any blockers or challenges..."
                              maxlength="1000"
                              required
                              oninput="countW(this, 'if{{ $key }}')"></textarea>
                    <div class="char-count"><span id="if{{ $key }}">0</span> / 1000</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-chat-square-text"></i>
                        Client Feedback
                    </label>
                    <textarea class="form-control" rows="3"
                              name="reports[{{ $key }}][client_feedback]"
                              placeholder="Any feedback received from the client..."
                              maxlength="500"
                              required
                              oninput="countW(this, 'cf{{ $key }}')"></textarea>
                    <div class="char-count"><span id="cf{{ $key }}">0</span> / 500</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-lightbulb"></i>
                        Learning Update
                    </label>
                    <textarea class="form-control" rows="3"
                              name="reports[{{ $key }}][learning_update]"
                              placeholder="Skills learned or knowledge gained..."
                              maxlength="500"
                              required
                              oninput="countW(this, 'lu{{ $key }}')"></textarea>
                    <div class="char-count"><span id="lu{{ $key }}">0</span> / 500</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-trophy"></i>
                        Key Outcomes
                    </label>
                    <textarea class="form-control" rows="3"
                              name="reports[{{ $key }}][key_outcomes]"
                              placeholder="Key deliverables or results achieved..."
                              maxlength="500"
                              required
                              oninput="countW(this, 'ko{{ $key }}')"></textarea>
                    <div class="char-count"><span id="ko{{ $key }}">0</span> / 500</div>
                </div>
                <div class="col-12">
                    <label class="form-label">
                        <i class="bi bi-sticky"></i>
                        Additional Notes
                    </label>
                    <textarea class="form-control" rows="2"
                              name="reports[{{ $key }}][additional_notes]"
                              placeholder="Any other notes or observations..."
                              maxlength="500"
                              required
                              oninput="countW(this, 'an{{ $key }}')"></textarea>
                    <div class="char-count"><span id="an{{ $key }}">0</span> / 500</div>
                </div>

                {{-- Project status --}}
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="bi bi-flag"></i>
                        Project Status
                    </label>
                    <select class="form-select" name="reports[{{ $key }}][project_status]" required>
                        @foreach(['On Track', 'At Risk', 'Delayed', 'Completed', 'On Hold'] as $s)
                        <option value="{{ $s }}" {{ $week['project_status'] === $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </div>

</div>

@endforeach

{{-- Submit --}}
<div class="d-flex align-items-center justify-content-between p-3 rounded-3 mt-2" style="background: #F8FAFC; border: 1px solid var(--border);">
    <div>
        <div style="font-size: 13px; font-weight: 600; color: var(--text);">Ready to file?</div>
        <div style="font-size: 12px; color: var(--muted);">This will save your weekly report for {{ now()->startOfWeek()->format('d M') }} – {{ now()->endOfWeek()->format('d M Y') }}.</div>
    </div>
    <button type="submit" class="btn btn-success" id="weeklySubmitBtn">
        <i class="bi bi-send-fill"></i>
        Save Weekly Report
    </button>
</div>

@endif

</form>

<script>
function countW(el, id) {
    var c = document.getElementById(id);
    if (c) c.textContent = el.value.length;
}

var wForm = document.getElementById('weeklyForm');
if (wForm) {
    wForm.addEventListener('submit', function () {
        var btn = document.getElementById('weeklySubmitBtn');
        if (btn) {
            btn.innerHTML = '<span class="spin-anim">↻</span> Saving...';
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.8';
        }
    });
}
</script>
