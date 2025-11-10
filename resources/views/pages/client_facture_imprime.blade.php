<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $reservation->id }}</title>
    <style>
        /* CSS simple pour PDF */
        body { font-family: sans-serif; margin: 0; padding: 0; font-size: 10pt; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); line-height: 1.6; }
        .header { display: flex; justify-content: space-between; margin-bottom: 25px; }
        h1 { color: #ff7a00; font-size: 20pt; margin: 0; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td, table th { padding: 8px; border-bottom: 1px solid #ddd; }
        .item-details th { background: #eee; border-bottom: 2px solid #ddd; }
        .total-row td { border-top: 2px solid #ff7a00; font-size: 11pt; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; text-align: center; font-size: 8pt; color: #777; }
    </style>
</head>
<body>

    <div class="invoice-box">

        <div class="header">
            <div>
                <h1>FACTURE</h1>
                Facture N°: **{{ $reservation->id }}**<br>
                Date d'émission: **{{ now()->format('d/m/Y') }}**
            </div>
            <div class="text-right">
                **Afrik'Hub Résidences**<br>
                Service de Réservation<br>
                Contact: [Votre Contact]
            </div>
        </div>

        <table>
            <tr>
                <td style="width: 50%;">
                    **Facturé à :**<br>
                    {{ $reservation->user->name }}<br>
                    {{ $reservation->user->email }}
                </td>
                <td class="text-right">
                    **Résidence :**<br>
                    {{ $reservation->residence->nom }}<br>
                    {{ $reservation->residence->ville }}, {{ $reservation->residence->pays }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px;">
            **Période de Location :**<br>
            Du **{{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }}** au **{{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}**
            @php
                $arrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
                $depart = \Carbon\Carbon::parse($reservation->date_depart);
                $nuits = $depart->diffInDays($arrivee);
            @endphp
            ({{ $nuits }} nuit(s))
        </div>

        <table style="margin-top: 20px;" class="item-details">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Quantité</th>
                    <th class="text-right">Prix Unitaire</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hébergement - {{ $reservation->residence->nom }}</td>
                    <td class="text-right">{{ $nuits }} nuit(s)</td>
                    <td class="text-right">{{ number_format($reservation->residence->prix_journalier, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($nuits * $reservation->residence->prix_journalier, 0, ',', ' ') }} FCFA</td>
                </tr>
                </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL À PAYER</td>
                    <td class="text-right">{{ number_format($nuits * $reservation->residence->prix_journalier, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            Merci de votre confiance. Pour toute question, veuillez nous contacter.
        </div>
    </div>
</body>
</html>
