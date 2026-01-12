<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #444; line-height: 1.5; background-color: #f4f4f4; padding: 20px; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 4px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        
        /* En-tête Proforma */
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #006d77; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h1 { color: #006d77; margin: 0; font-size: 28px; text-transform: uppercase; }
        .invoice-title { text-align: right; }
        .invoice-title h2 { margin: 0; color: #006d77; font-size: 22px; }
        
        /* Infos Client & Facture */
        .info-section { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-box { vertical-align: top; width: 50%; }
        .info-label { color: #888; font-size: 12px; text-transform: uppercase; margin-bottom: 5px; }
        
        /* Tableau des prix */
        .invoice-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .invoice-table th { background: #f9fafb; border-bottom: 1px solid #eee; padding: 12px; text-align: left; font-size: 13px; color: #006d77; }
        .invoice-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        
        /* Totaux */
        .total-section { float: right; width: 250px; margin-top: 20px; }
        .total-row { display: flex; justify-content: space-between; padding: 10px 0; }
        .total-row.grand-total { border-top: 2px solid #006d77; font-weight: bold; font-size: 18px; color: #006d77; }
        
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 12px; background: #e0f2f1; color: #006d77; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 11px; color: #999; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; }
        .clear { clear: both; }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td class="company-info">
                    <h1>Afrik'Hub</h1>
                    <p style="font-size: 12px; margin: 5px 0;">Abidjan, Côte d'Ivoire<br>Contact: +225 0103090616</p>
                </td>
                <td class="invoice-title" style="text-align: right;">
                    <h2>FACTURE PROFORMA</h2>
                    <p style="font-size: 13px;">N° {{ $reservation->reservation_code }}<br>Date: {{ date('d/m/Y') }}</p>
                </td>
            </tr>
        </table>

        <hr style="border: 0; border-top: 2px solid #006d77; margin: 20px 0;">

        <table class="info-section">
            <tr>
                <td class="info-box">
                    <div class="info-label">Facturé à</div>
                    <strong>{{ $reservation->client }}</strong><br>
                    Email: {{ $reservation->user->email ?? 'N/A' }}
                </td>
                <td class="info-box" style="text-align: right;">
                    <div class="info-label">Statut</div>
                    <span class="status-badge">{{ strtoupper($statutTitre) }}</span>
                </td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Détails</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Séjour à la Résidence : {{ $reservation->residence->nom }}</strong><br>
                        <small style="color: #777;">Du {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->date_arrivee)->diffInDays($reservation->date_depart) }} nuit(s)
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Sous-total:</span>
                <span>{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL TTC:</span>
                <span>{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
        
        <div class="clear"></div>

        <div style="margin-top: 40px; font-size: 13px;">
            <p><strong>Note :</strong> {{ $messageCustom }}</p>
            <p style="color: #666; font-style: italic;">Cette facture proforma est valable pour une durée de 48 heures. Elle ne constitue pas une quittance de paiement définitive.</p>
        </div>

        <div class="footer">
            Afrik'Hub - Loin de chez vous, comme chez vous.<br>
            Contact: 0103090616 | afrikhub1@gmail.com<br>
            © {{ date('Y') }} Tous droits réservés.
        </div>
    </div>
</body>
</html>