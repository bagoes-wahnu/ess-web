<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LateNotifBASTFisik extends Mailable
{
    use Queueable, SerializesModels;

    protected $userMail;
    protected $subjectMail;
    protected $viewMail;
    protected $permohonan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $view, $permohonan)
    {
        $this->userMail = $user;
        $this->subjectMail = $subject;
        $this->viewMail = $view;
        $this->permohonan = $permohonan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->viewMail)
        ->subject($this->subjectMail)
        ->to($this->userMail->email, $this->userMail->nama)
        ->with([
            'userMail' => $this->userMail,
            'permohonan' => $this->permohonan
        ]);
    }
}
