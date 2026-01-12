<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationProformaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $statutTitre;
    public $messageCustom;

    public function __construct($reservation, $statutTitre = "Facture Proforma", $messageCustom = null)
    {
        $this->reservation = $reservation;
        $this->statutTitre = $statutTitre;
        $this->messageCustom = $messageCustom ?? "Votre réservation a été enregistrée avec succès. Voici votre facture proforma.";
    }

    public function build()
    {
        $pdf = Pdf::loadView('emails.facture_proforma', [
            'reservation' => $this->reservation,
            'statutTitre' => $this->statutTitre,
            'messageCustom' => $this->messageCustom,
        ]);

        return $this->subject("Votre facture proforma - Afrik'Hub")
            ->view('emails.reservation_simple', [
                'reservation' => $this->reservation
            ])
            ->attachData($pdf->output(), "facture_proforma_{$this->reservation->reservation_code}.pdf");
    }
}
