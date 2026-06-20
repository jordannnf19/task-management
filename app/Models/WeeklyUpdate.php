<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyUpdate extends Model
{
    protected $fillable = [
        'user_id',
        'reporting_week',
        'project_name',
        'project_priority',
        'deadline_date',
        'estimated_hours',
        'actual_hours_worked',
        'activities_completed',
        'issues_faced',
        'project_status',
        'client_feedback',
        'plan_for_next_week',
        'learning_update',
        'key_outcomes',
        'additional_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}