<form action="{{ route('daily.store') }}" method="POST" id="dailyForm">
    @csrf

    <div id="taskContainer"></div>

    {{-- Add Task Button --}}
    <button type="button" id="addTaskBtn" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-plus-circle"></i>
        Add Another Task
    </button>

    {{-- Submit --}}
    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #F8FAFC; border: 1px solid var(--border);">
        <div style="flex: 1;">
            <div style="font-size: 13px; font-weight: 600; color: var(--text);">Ready to submit?</div>
            <div style="font-size: 12px; color: var(--muted);">All task cards will be saved as today's update.</div>
        </div>
        <button type="submit" class="btn btn-primary" id="submitDailyBtn">
            <i class="bi bi-send-fill"></i>
            Submit Daily Update
        </button>
    </div>

</form>

<script>
(function () {
    var taskCount = 0;

    var priorityColors = {
        'High':   { bg: '#FEF2F2', color: '#DC2626' },
        'Medium': { bg: '#FFFBEB', color: '#D97706' },
        'Low':    { bg: '#ECFDF5', color: '#059669' }
    };

    function createTaskCard() {
        taskCount++;
        var n = taskCount;

        var today = new Date().toISOString().split('T')[0];

        var html = '<div class="task-card-wrap" id="taskCard' + n + '">' +

            '<div class="task-card-header" onclick="toggleTask(' + n + ')">' +
                '<div class="task-no-badge">' + n + '</div>' +
                '<span class="task-card-title">Task ' + n + ' &mdash; <span class="task-label-' + n + '" style="color: var(--muted); font-weight: 500;">Fill in details below</span></span>' +
                '<i class="bi bi-chevron-down task-toggle-icon" id="taskToggle' + n + '"></i>' +
                '<button type="button" class="task-remove-btn" onclick="removeTask(' + n + ', event)" title="Remove task">' +
                    '<i class="bi bi-trash3"></i>' +
                '</button>' +
            '</div>' +

            '<div class="task-card-body" id="taskBody' + n + '">' +
                '<div class="row g-3">' +

                    '<div class="col-md-6">' +
                        '<label class="form-label"><i class="bi bi-folder2"></i> Project Name</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-folder"></i>' +
                            '<input type="text" name="tasks[' + n + '][project_name]" class="form-control" placeholder="e.g. Website Redesign" oninput="updateTaskLabel(' + n + ', this.value)">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-6">' +
                        '<label class="form-label"><i class="bi bi-check2-square"></i> Task Name</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-pencil"></i>' +
                            '<input type="text" name="tasks[' + n + '][task_name]" class="form-control" placeholder="Describe the task">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-4">' +
                        '<label class="form-label"><i class="bi bi-flag"></i> Priority</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-flag"></i>' +
                            '<select name="tasks[' + n + '][priority]" class="form-select">' +
                                '<option value="High">🔴 High</option>' +
                                '<option value="Medium" selected>🟡 Medium</option>' +
                                '<option value="Low">🟢 Low</option>' +
                            '</select>' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-4">' +
                        '<label class="form-label"><i class="bi bi-calendar-event"></i> Start Date</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-calendar"></i>' +
                            '<input type="date" name="tasks[' + n + '][start_date]" class="form-control" value="' + today + '">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-4">' +
                        '<label class="form-label"><i class="bi bi-calendar-check"></i> End Date</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-calendar2-check"></i>' +
                            '<input type="date" name="tasks[' + n + '][end_date]" class="form-control" value="' + today + '">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-3">' +
                        '<label class="form-label"><i class="bi bi-hourglass-split"></i> Est. Hours</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-hourglass"></i>' +
                            '<input type="number" step="0.5" min="0" name="tasks[' + n + '][estimated_hours]" class="form-control" placeholder="0.0">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-3">' +
                        '<label class="form-label"><i class="bi bi-stopwatch"></i> Hours Spent</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-stopwatch"></i>' +
                            '<input type="number" step="0.5" min="0" name="tasks[' + n + '][hours_spent]" class="form-control" placeholder="0.0">' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-md-6">' +
                        '<label class="form-label"><i class="bi bi-activity"></i> Status</label>' +
                        '<div class="input-icon-wrap">' +
                            '<i class="bi bi-circle-half"></i>' +
                            '<select name="tasks[' + n + '][status]" class="form-select">' +
                                '<option value="Completed">✅ Completed</option>' +
                                '<option value="In Progress" selected>🔄 In Progress</option>' +
                                '<option value="Pending">⏳ Pending</option>' +
                                '<option value="Hold">⏸ Hold</option>' +
                            '</select>' +
                        '</div>' +
                    '</div>' +

                    '<div class="col-12">' +
                        '<label class="form-label"><i class="bi bi-journal-text"></i> Current Progress</label>' +
                        '<textarea name="tasks[' + n + '][current_progress]" class="form-control" rows="3" placeholder="Describe what was accomplished today..." maxlength="1000" oninput="countChars(this, \'cp' + n + '\')"></textarea>' +
                        '<div class="char-count"><span id="cp' + n + '">0</span> / 1000</div>' +
                    '</div>' +

                    '<div class="col-12">' +
                        '<label class="form-label"><i class="bi bi-arrow-right-circle"></i> Tomorrow\'s Plan</label>' +
                        '<textarea name="tasks[' + n + '][tomorrows_plan]" class="form-control" rows="3" placeholder="What will you work on tomorrow?" maxlength="1000" oninput="countChars(this, \'tp' + n + '\')"></textarea>' +
                        '<div class="char-count"><span id="tp' + n + '">0</span> / 1000</div>' +
                    '</div>' +

                '</div>' +
            '</div>' +

        '</div>';

        document.getElementById('taskContainer').insertAdjacentHTML('beforeend', html);
    }

    window.toggleTask = function (n) {
        var card = document.getElementById('taskCard' + n);
        if (card) card.classList.toggle('collapsed');
    };

    window.removeTask = function (n, e) {
        e.stopPropagation();
        var card = document.getElementById('taskCard' + n);
        if (card) {
            card.style.animation = 'none';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            card.style.transition = 'all 0.2s';
            setTimeout(function() { card.remove(); }, 200);
        }
    };

    window.updateTaskLabel = function (n, val) {
        var el = document.querySelector('.task-label-' + n);
        if (el) el.textContent = val || 'Fill in details below';
    };

    window.countChars = function (el, counterId) {
        var c = document.getElementById(counterId);
        if (c) c.textContent = el.value.length;
    };

    // Initialize with 4 task cards
    for (var i = 0; i < 4; i++) {
        createTaskCard();
    }

    document.getElementById('addTaskBtn').addEventListener('click', function () {
        createTaskCard();
        // Scroll to new card
        var cards = document.querySelectorAll('.task-card-wrap');
        if (cards.length) {
            cards[cards.length - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Submit loading state
    document.getElementById('dailyForm').addEventListener('submit', function () {
        var btn = document.getElementById('submitDailyBtn');
        if (btn) {
            btn.classList.add('loading');
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin-anim"></i> Submitting...';
        }
    });
})();
</script>

<style>
@keyframes spin-anim { to { transform: rotate(360deg); } }
.spin-anim { display: inline-block; animation: spin-anim 0.7s linear infinite; }
</style>
