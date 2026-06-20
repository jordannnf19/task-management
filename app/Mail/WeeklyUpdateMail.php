<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WeeklyUpdateMail extends Mailable
{
public $reports;
public $user;

    public function __construct(
        $reports,
        $user = null
)
{
    $this->reports = $reports;
    $this->user = $user;
}

public function build()
{
    return $this
        ->subject(
            'Weekly Update - ' . ($this->user?->name ?? 'Employee')
        )
        ->view('emails.weekly-update');
}
}
