<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class DailyUpdateMail extends Mailable
{
    public $tasks;
    public $user;

    public function __construct($tasks, $user = null)
    {
        $this->tasks = $tasks;
        $this->user = $user;
    }

    public function build()
    {
return $this
        ->subject(
            'Daily Update - ' . ($this->user?->name ?? 'Employee')
        )
        ->view('emails.daily-update');
    }
}
