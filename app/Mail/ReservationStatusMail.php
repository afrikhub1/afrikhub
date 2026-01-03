<?php
namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusMail extends Mailable
{
use Queueable, SerializesModels;

public $reservation;
public $messageCustom;
public $statutTitre;

public function __construct(Reservation $reservation, $statutTitre, $messageCustom)
{
$this->reservation = $reservation;
$this->statutTitre = $statutTitre;
$this->messageCustom = $messageCustom;
}

public function build()
{
return $this->subject("Afrique Hub - " . $this->statutTitre)
->view('emails.reservation_status');
}
}
