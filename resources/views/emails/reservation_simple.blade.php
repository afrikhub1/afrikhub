<div style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6; max-width: 600px;">
    
    <h2 style="color: #006d77; margin-bottom: 20px;">Bonjour {{ $reservation->client }},</h2>

    <p>Nous avons bien enregistré votre demande de réservation pour la résidence <strong>{{ $reservation->residence->nom }}</strong>.</p>

    <p>Veuillez trouver ci-dessous le récapitulatif de votre <strong>facture proforma n°{{ $reservation->reservation_code }}</strong>. Ce document est nécessaire pour confirmer votre séjour.</p>

    <div style="background-color: #f8fafc; border-left: 4px solid #006d77; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0;">
        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td style="padding-bottom: 8px;"><strong>Dates :</strong></td>
                <td style="padding-bottom: 8px; text-align: right;">Du {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;"><strong>Séjour :</strong></td>
                <td style="padding-bottom: 8px; text-align: right;">{{ \Carbon\Carbon::parse($reservation->date_arrivee)->diffInDays($reservation->date_depart) }} nuits</td>
            </tr>
            <tr style="font-size: 16px; color: #006d77;">
                <td><strong>Montant Total :</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
        </table>
    </div>

    <p>Pour confirmer définitivement votre réservation, merci de procéder au règlement selon les modalités indiquées dans la facture jointe.</p>

    <div style="text-align: center; margin: 35px 0;">
        <a href="{{ url('/reserver/paiement/'.$reservation->reservation_code) }}" 
           style="background-color: #006d77; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block; box-shadow: 0 4px 12px rgba(0,109,119,0.2);">
           Confirmer et Payer en ligne
        </a>
    </div>

    <p style="font-size: 14px;">Toute l'équipe d'<strong>Afrik'Hub</strong> vous remercie pour votre confiance et reste à votre entière disposition pour toute question.</p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 0;">
        Cordialement,<br>
        <strong>Service Client Afrik'Hub</strong><br>
        <span style="color: #006d77;">Loin de chez vous, comme chez vous.</span>
    </p>
</div>