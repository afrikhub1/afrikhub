<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Correction : Fond blanc pur et suppression des marges inutiles */
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #444; 
            line-height: 1.5; 
            background-color: #ffffff; /* Fond blanc */
            margin: 0;
            padding: 0;
        }
        
        /* Correction : Suppression de l'ombre (box-shadow) et du cadre gris */
        .container { 
            width: 100%; 
            max-width: 800px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 20px; /* Réduit pour mieux tenir sur une page A4 */
        }
        
        /* En-tête Proforma */
        .invoice-header-table { width: 100%; border-bottom: 2px solid #006d77; padding-bottom: 15px; margin-bottom: 20px; }
        .company-info h1 { color: #006d77; margin: 0; font-size: 26px; text-transform: uppercase; }
        .invoice-title h2 { margin: 0; color: #006d77; font-size: 20px; }
        
        /* Infos Client & Facture */
        .info-section { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-box { vertical-align: top; width: 50%; }
        .info-label { color: #888; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; }
        
        /* Tableau des prix */
        .invoice-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .invoice-table th { background: #f9fafb; border-bottom: 1px solid #eee; padding: 12px; text-align: left; font-size: 13px; color: #006d77; }
        .invoice-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        
        /* Totaux alignés proprement pour PDF */
        .total-table { float: right; width: 250px; margin-top: 10px; border-collapse: collapse; }
        .total-table td { padding: 8px 0; }
        .grand-total { border-top: 2px solid #006d77; font-weight: bold; font-size: 16px; color: #006d77; }
        
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 11px; background: #e0f2f1; color: #006d77; border: 1px solid #b2dfdb; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 60px; border-top: 1px solid #eee; padding-top: 15px; }
        .clear { clear: both; }
    </style>
</head>

<body>
    <div class="container">
        <table class="invoice-header-table">
            <tr>
                <td class="company-info">
                    <h1>Afrik'Hub</h1>
                    <p style="font-size: 12px; margin: 5px 0;">Abidjan, Côte d'Ivoire<br>Contact: +225 0103090616</p>
                </td>
                <td style="text-align: right;" class="invoice-title">
                    <h2>FACTURE PROFORMA</h2>
                    <p style="font-size: 13px; margin: 5px 0;">N° {{ $reservation->reservation_code }}<br>Date: {{ date('d/m/Y') }}</p>
                </td>
            </tr>
        </table>

        <table class="info-section">
            <tr>
                <td class="info-box">
                    <div class="info-label">Facturé à</div>
                    <strong style="font-size: 16px;">{{ $reservation->client }}</strong><br>
                    <span style="font-size: 13px;">Email: {{ $reservation->user->email ?? 'N/A' }}</span>
                </td>
                <td class="info-box" style="text-align: right;">
                    <div class="info-label">Statut de la demande</div>
                    <span class="status-badge">{{ strtoupper($statutTitre) }}</span>
                </td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="50%">Description</th>
                    <th width="20%">Détails</th>
                    <th width="30%" style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Séjour : {{ $reservation->residence->nom }}</strong><br>
                        <small style="color: #777;">Du {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->date_arrivee)->diffInDays($reservation->date_depart) }} nuit(s)
                    </td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="total-table">
            <tr>
                <td style="font-size: 13px;">Sous-total :</td>
                <td style="text-align: right; font-size: 13px;">{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="grand-total">
                <td>TOTAL TTC :</td>
                <td style="text-align: right;">{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
        
        <div class="clear"></div>

        <div style="margin-top: 50px; font-size: 12px; border-left: 3px solid #006d77; padding-left: 15px;">
            <p><strong>Note :</strong> {{ $messageCustom }}</p>
            <p style="color: #666; font-style: italic;">Cette facture proforma est valable 48 heures. Elle ne constitue pas une preuve de paiement.</p>
        </div>

        <div class="footer">
            <strong>Afrik'Hub</strong> - Loin de chez vous, comme chez vous.<br>
            Contact: 0103090616 | afrikhub1@gmail.com<br>
            © {{ date('Y') }} Tous droits réservés.
        </div>
    </div>
</body>
</html>