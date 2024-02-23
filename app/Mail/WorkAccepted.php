<?php

namespace App\Mail;

use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $work;
    public $userName;
    public $userCountry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Work $work)
    {
        $this->work = $work;
        $this->userName = $work->user->name;
        $this->userCountry = $work->user->country;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Trabajo Aceptado # '.$this->work->id.' : '.$this->work->title.' - '.$this->userName.' ('.$this->userCountry.')')->view('emails.work_accepted');
    }
}
