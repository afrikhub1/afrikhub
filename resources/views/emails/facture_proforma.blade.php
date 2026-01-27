<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Reset complet pour PDF */
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #444; 
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        
        /* Conteneur principal centré */
        .wrapper {
            width: 100%;
            margin: 0 auto;
            padding: 40px; /* Espace interne identique à gauche et à droite */
            box-sizing: border-box;
        }

        table { width: 100%; border-collapse: collapse; }
        
        /* Header */
        .invoice-header-table { 
            border-bottom: 2px solid #006d77; 
            padding-bottom: 15px; 
            margin-bottom: 30px; 
        }
        
        .company-info h1 { color: #006d77; margin: 0; font-size: 26px; text-transform: uppercase; }
        .invoice-title h2 { margin: 0; color: #006d77; font-size: 20px; text-align: right; }
        
        /* Section Infos */
        .info-section { margin-bottom: 40px; }
        .info-label { color: #888; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; }
        
        /* Tableau des prix */
        .invoice-table { margin: 20px 0; }
        .invoice-table th { 
            background: #f9fafb; 
            border-bottom: 1px solid #eee; 
            padding: 12px; 
            text-align: left; 
            font-size: 13px; 
            color: #006d77; 
        }
        .invoice-table td { padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        
        /* Totaux alignés à droite */
        .total-container { text-align: right; margin-top: 20px; }
        .total-table { width: 280px; margin-left: auto; } /* Force l'alignement à droite */
        .total-table td { padding: 8px 5px; }
        .grand-total { border-top: 2px solid #006d77; font-weight: bold; font-size: 18px; color: #006d77; }
        
        .status-badge { 
            display: inline-block; 
            padding: 6px 15px; 
            background: #e0f2f1; 
            color: #006d77; 
            border-radius: 4px; 
            font-size: 11px; 
            font-weight: bold;
        }

        .footer { 
            text-align: center; 
            font-size: 10px; 
            color: #999; 
            margin-top: 80px; 
            border-top: 1px solid #eee; 
            padding-top: 20px; 
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table class="invoice-header-table">
            <tr>
                <td>
                    <h1>Afrik'Hub</h1>
                    <p style="font-size: 12px; margin-top: 5px;">
                        Abidjan, Côte d'Ivoire<br>
                        Contact: +225 0103090616
                    </p>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <h2>FACTURE PROFORMA</h2>
                    <p style="font-size: 13px; margin-top: 5px;">
                        N° {{ $reservation->reservation_code }}<br>
                        Date: {{ date('d/m/Y') }}
                    </p>
                </td>
            </tr>
        </table>

        <table class="info-section">
            <tr>
                <td width="60%">
                    <div class="info-label">Facturé à</div>
                    <strong style="font-size: 18px; color: #333;">{{ $reservation->client }}</strong><br>
                    <span style="font-size: 13px;">Email: {{ $reservation->user->email ?? 'N/A' }}</span>
                </td>
                <td width="40%" style="text-align: right; vertical-align: bottom;">
                    <div class="info-label" style="margin-bottom: 8px;">Statut de la demande</div>
                    <span class="status-badge">{{ strtoupper($statutTitre) }}</span>
                </td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="50%">Description du service</th>
                    <th width="20%">Durée</th>
                    <th width="30%" style="text-align: right;">Montant Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Location : {{ $reservation->residence->nom }}</strong><br>
                        <span style="color: #777; font-size: 12px;">Période : Du {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($reservation->date_arrivee)->diffInDays($reservation->date_depart) }} nuit(s)
                    </td>
                    <td style="text-align: right; font-weight: bold; font-size: 15px;">
                        {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total-container">
            <table class="total-table">
                <tr>
                    <td style="font-size: 13px; color: #666;">Sous-total :</td>
                    <td style="text-align: right; font-size: 13px;">{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL TTC :</td>
                    <td style="text-align: right;">{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div style="margin-top: 60px; font-size: 12px; border-left: 4px solid #006d77; padding-left: 15px; color: #555;">
            <p style="margin-bottom: 5px;"><strong>Note importante :</strong></p>
            <p style="margin: 0;">{{ $messageCustom }}</p>
            <p style="margin-top: 10px; color: #888; font-style: italic;">
                Cette facture proforma est valable 48 heures. Elle ne constitue pas une preuve de paiement définitive.
            </p>
        </div>

        <div class="footer">
            <strong>Afrik'Hub</strong> - Loin de chez vous, comme chez vous.<br>
            Abidjan, Côte d'Ivoire | Contact: +225 0103090616 | afrikhub1@gmail.com<br>
            © {{ date('Y') }} Tous droits réservés.
        </div>
    </div>
</body>
</html>