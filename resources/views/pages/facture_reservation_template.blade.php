<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture N°{{ $reservation->id }}</title>
    <style>
        /* CSS intégré pour DOMPDF - Utilisez des unités de mesure absolues (px, mm) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 10pt;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #5C6BC0; /* Bleu Indigo */
            padding-bottom: 10px;
        }
        .header h1 {
            color: #5C6BC0;
            font-size: 20pt;
            margin: 0;
        }
        .details-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .details-box p {
            margin: 2px 0;
        }
        .table-facture {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-facture th, .table-facture td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table-facture th {
            background-color: #F8F8F8;
            color: #444;
            font-size: 10pt;
        }
        .total-row td {
            font-size: 12pt;
            font-weight: bold;
            background-color: #E8EAF6; /* Light Indigo */
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    @php
        // Calcul des dates et nuits
        $dateArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
        $dateDepart = \Carbon\Carbon::parse($reservation->date_depart);
        $jours = $dateDepart->diffInDays($dateArrivee);

        // Supposons que le prix_unitaire est stocké dans la résidence (prix_par_nuit)
        $prixUnitaire = $reservation->residence->prix_par_nuit ?? 0;
        $montantHT = $prixUnitaire * $jours;
        $TVA = 0.18; // Exemple de TVA à 18%
        $montantTVA = $montantHT * $TVA;
        $montantTotal = $reservation->total; // Utilisons le total stocké pour être précis

        // Informations Client (user)
        $client = $reservation->user;
    @endphp

    <div class="container">

        <div class="header">
            <h1>AFRIK'HUB</h1>
            <p style="font-size: 9pt;">Service de Réservation de Résidences. | Contact: contact@afrikhub.com</p>
        </div>

        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="font-size: 16pt; font-weight: bold; margin-bottom: 10px;">FACTURE N° {{ $reservation->id }}</p>
                    <p>Date de la facture : {{ now()->format('d/m/Y') }}</p>
                    <p>Date de réservation : {{ $reservation->created_at->format('d/m/Y') }}</p>
                    <p>Statut de paiement : {{ ucfirst($reservation->status) }}</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="details-box">
                        <p style="font-weight: bold;">Facturé à :</p>
                        <p>{{ $client->name }}</p>
                        <p>{{ $client->email }}</p>
                        {{-- Ajoutez d'autres détails du client si disponibles --}}
                    </div>
                </td>
            </tr>
        </table>

        <p style="font-size: 14pt; font-weight: bold; color: #444; margin-bottom: 10px;">Détails du Séjour</p>
        <div class="details-box">
            <p><span style="font-weight: bold;">Résidence :</span> {{ $reservation->residence->nom }}</p>
            <p><span style="font-weight: bold;">Adresse :</span> {{ $reservation->residence->adresse }}, {{ $reservation->residence->ville }}</p>
            <p><span style="font-weight: bold;">Période :</span> Du {{ $dateArrivee->format('d M Y') }} au {{ $dateDepart->format('d M Y') }}</p>
            <p><span style="font-weight: bold;">Nombres de Personnes :</span> {{ $reservation->personnes }}</p>
        </div>

        <table class="table-facture">
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15%;">Quantité</th>
                    <th style="width: 20%; text-align: right;">Prix Unitaire</th>
                    <th style="width: 15%; text-align: right;">Total HT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hébergement ({{ $reservation->residence->nom }})</td>
                    <td>{{ $jours }} nuits</td>
                    <td style="text-align: right;">{{ number_format($prixUnitaire, 0, ',', ' ') }} FCFA</td>
                    <td style="text-align: right;">{{ number_format($montantHT, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 300px; float: right;" class="table-facture">
            <tbody>
                <tr>
                    <td style="font-weight: bold; background-color: #F8F8F8;">Montant H.T. :</td>
                    <td style="text-align: right;">{{ number_format($montantHT, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background-color: #F8F8F8;">T.V.A. ({{ $TVA * 100 }}%) :</td>
                    <td style="text-align: right;">{{ number_format($montantTVA, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL NET À PAYER :</td>
                    <td style="text-align: right;">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div style="clear: both;"></div>

        <div class="footer">
            Merci d'avoir choisi AFRIK'HUB. Cette facture est générée par ordinateur et est valide sans signature.
        </div>
    </div>
</body>
</html>
