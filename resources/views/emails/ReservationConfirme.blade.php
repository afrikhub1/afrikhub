<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 20px; border-radius: 10px; }
        .header { background: linear-gradient(135deg, #006d77, #00afb9); color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .details { background: #f9fafb; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Afrik'Hub</h1>
        </div>
        <div class="content">
            <h2>{{ $statutTitre }}</h2>
            <p>Bonjour {{ $reservation->client }},</p>
            <p>{{ $messageCustom }}</p>

            <div class="details">
                <p><strong>Code :</strong> {{ $reservation->reservation_code }}</p>
                <p><strong>Résidence :</strong> {{ $reservation->residence->nom }}</p>
                <p><strong>Arrivée :</strong> {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}</p>
                <p><strong>Départ :</strong> {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</p>
                <p><strong>Total :</strong> {{ number_format($reservation->total, 0, ',', ' ') }} FCFA</p>
            </div>

            <p>Merci de nous faire confiance.</p>
            <a href="{{ route('paiement.qr') }}" 
                style="background-color: #006d77; color: #ffffff; padding: 15px 35px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 16px; display: inline-block; transition: background-color 0.3s;">
                Payer {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
            </a>
        </div>
        <div class="footer">
            © {{ date('Y') }} Afrique Hub. Loin de chez vous, comme chez vous.
        </div>
    </div>
</body>
</html>
