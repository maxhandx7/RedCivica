<?php

namespace App\Mail;

use App\Models\Actividad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $actividad;

    public function __construct(Actividad $actividad)
    {
        $this->actividad = $actividad;
    }

    public function build()
    {
        return $this->subject('¡Nueva notificacion en PoliticFriends!')
                    ->view('emails.notificacion');
    }
}
