<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class TaskReminderMail extends Mailable
{
    public function __construct(
        public User $user,
        public string $type
    ) {
    }

    public function build()
    {
        $label = ucfirst($this->type);

        return $this
            ->subject($label . ' Task Reminder')
            ->view('emails.task-reminder');
    }
}
