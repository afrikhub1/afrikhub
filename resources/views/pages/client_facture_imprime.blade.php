@php
    // --- FONCTIONS POUR DOMPDF ---
    // Fonction pour obtenir le chemin de l'image en Base64 (obligatoire pour DomPDF)
    function imageToBase64($path) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    // Chemin vers votre logo (à vérifier !)
    $logoPath = public_path('assets/images/logo_01.png');

    // Encode le logo
    $logoBase64 = file_exists($logoPath) ? imageToBase64($logoPath) : null;

    // Calculs de réservation
    $arrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
    $depart = \Carbon\Carbon::parse($reservation->date_depart);
    $nuits = $depart->diffInDays($arrivee);
    $montantTotal = $nuits * $reservation->residence->prix_journalier;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture N°{{ $reservation->id }}</title>
    <style>
        /* CSS SIMPLE POUR PDF */
        body { font-family: sans-serif; margin: 0; padding: 0; font-size: 10pt; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; line-height: 1.6; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .color-primary { color: #ff7a00; }
        h1 { font-size: 24pt; margin: 0; }
        h2 { font-size: 12pt; margin: 0; font-weight: bold; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td, table th { padding: 8px; border-bottom: 1px solid #eee; }
        .item-details th { background: #f7f7f7; border-bottom: 2px solid #ddd; font-weight: 600; }
        .total-row td { border-top: 2px solid #ff7a00; font-size: 11pt; font-weight: bold; }
        .text-right { text-align: right; }
        .separator { margin: 25px 0; border-top: 1px dashed #ccc; }
        .footer { margin-top: 50px; text-align: center; font-size: 8pt; color: #777; }
    </style>
</head>
<body>

    <div class="invoice-box">

        <div class="header" style="width: 100%;">
            <div style="width: 50%;">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo Afrik'Hub" style="width: 140px; height: auto; max-width: 100%;">
                @else
                    <h1 class="color-primary">Afrik'Hub</h1>
                @endif
                <h1 class="color-primary" style="margin-top: 15px;">FACTURE</h1>
            </div>

            <div class="text-right" style="width: 50%;">
                <h2>Afrik'Hub Résidences</h2>
                Service de Réservation<br>
                Adresse [...]<br>
                Email [votre.email@exemple.com]
            </div>
        </div>

        <div class="separator"></div>

        <table style="margin-bottom: 20px;">
            <tr>
                <td style="width: 100%;">
                    <strong>Facturé à :</strong><br>
                    {{ $reservation->user->name }}<br>
                    {{ $reservation->user->email }}
                </td>
                <td class="text-right">
                    <strong>N° Facture :</strong> {{ $reservation->id }}<br>
                    <strong>Date d'émission :</strong> {{ now()->format('d/m/Y') }}<br>
                    <strong>Statut :</strong> Payée (ou à payer)
                </td>
            </tr>
        </table>

        <div style="padding: 10px; background: #fff5e6; border-left: 5px solid #ff7a00;">
            <strong>Résidence :</strong> {{ $reservation->residence->nom }}<br>
            <strong>Localisation :</strong> {{ $reservation->residence->ville }}, {{ $reservation->residence->pays }}
        </div>

        <table style="margin-top: 30px;" class="item-details">
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
                    <td>
                        Hébergement du {{ $arrivee->format('d/m/Y') }} au {{ $depart->format('d/m/Y') }}
                    </td>
                    <td class="text-right">{{ $nuits }} nuit(s)</td>
                    <td class="text-right">{{ number_format($reservation->residence->prix_journalier, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">MONTANT TOTAL PAYÉ</td>
                    <td class="text-right color-primary">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p style="margin-bottom: 5px;">Merci d'avoir choisi Afrik'Hub. Au plaisir de vous accueillir bientôt.</p>
            <p>Facture générée le {{ now()->format('d/m/Y à H:i:s') }}.</p>
        </div>
    </div>
</body>
</html>
