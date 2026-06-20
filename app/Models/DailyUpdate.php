<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyUpdate extends Model
{
    protected $fillable = [
        'user_id',
        'task_no',
        'project_name',
        'task_name',
        'priority',
        'start_date',
        'end_date',
        'estimated_hours',
        'hours_spent',
        'status',
        'current_progress',
        'tomorrows_plan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}