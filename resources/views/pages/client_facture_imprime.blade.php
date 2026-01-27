@php
    // --- FONCTIONS POUR DOMPDF ---
    function imageToBase64($path) {
        if (!file_exists($path)) return null;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    $logoPath = public_path('assets/images/logo_01.png');
    $logoBase64 = imageToBase64($logoPath);

    // Calculs
    $arrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
    $depart = \Carbon\Carbon::parse($reservation->date_depart);
    $nuits = $depart->diffInDays($arrivee);
    $montantTotal = $nuits * $reservation->residence->prix_journalier;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture N°{{ $reservation->id }} — Afrik'Hub</title>
    <style>
        /* CSS OPTIMISÉ POUR DOMPDF (COMPATIBLE TABLETTES/MOTEURS PDF) */
        @page { margin: 0cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            color: #334155;
            background-color: #ffffff;
            font-size: 10pt;
        }
        .container { padding: 40px; }
        
        /* BANDEAU DE DÉGRADÉ AFRIK'HUB */
        .brand-stripe {
            height: 8px;
            background: #006d77; /* Couleur de base si le dégradé n'est pas supporté */
            background: linear-gradient(to right, #006d77, #00afb9);
        }

        .header { width: 100%; margin-bottom: 40px; }
        .logo-box { width: 50%; vertical-align: top; }
        .info-box { width: 50%; text-align: right; vertical-align: top; }
        
        .color-primary { color: #006d77; }
        .text-turquoise { color: #00afb9; }
        
        h1 { font-size: 28pt; margin: 0; color: #006d77; font-weight: bold; letter-spacing: -1px; }
        .subtitle { font-size: 9pt; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

        .section-title {
            background: #f8fafc;
            padding: 10px;
            border-left: 4px solid #006d77;
            margin: 25px 0 15px 0;
            font-weight: bold;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { 
            text-align: left; 
            padding: 12px; 
            background-color: #f1f5f9; 
            color: #475569; 
            font-size: 9pt;
            border-bottom: 2px solid #e2e8f0;
        }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .total-box {
            margin-top: 30px;
            width: 40%;
            margin-left: 60%;
            border-top: 2px solid #006d77;
            padding-top: 10px;
        }
        
        .grand-total {
            font-size: 14pt;
            color: #006d77;
            font-weight: 800;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #ccfbf1;
            color: #0d9488;
        }
    </style>
</head>
<body>

    <div class="brand-stripe"></div>

    <div class="container">
        <table class="header">
            <tr>
                <td class="logo-box" style="border: none;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" style="width: 150px;">
                    @else
                        <h1>Afrik'Hub</h1>
                    @endif
                    <div style="margin-top: 10px;">
                        <span class="subtitle">Récapitulatif de Facturation</span>
                    </div>
                </td>
                <td class="info-box" style="border: none;">
                    <div style="font-size: 16pt; font-weight: bold; color: #1e293b;">FACTURE</div>
                    <div style="color: #64748b; margin-top: 5px;">
                        N° #{{ $reservation->reservation_code ?? $reservation->id }}<br>
                        Émise le : {{ now()->format('d/m/Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 40px;">
            <tr>
                <td style="width: 50%; border: none; padding-left: 0;">
                    <div style="color: #64748b; text-transform: uppercase; font-size: 8pt; font-weight: bold; margin-bottom: 5px;">Émetteur</div>
                    <div class="font-bold" style="color: #006d77;">Afrik'Hub Résidences</div>
                    Service Clientèle & Réservations<br>
                    Siège Social : Abidjan, Côte d'Ivoire<br>
                    contact@afrikhub.com
                </td>
                <td style="width: 50%; border: none; text-align: right; padding-right: 0;">
                    <div style="color: #64748b; text-transform: uppercase; font-size: 8pt; font-weight: bold; margin-bottom: 5px;">Client</div>
                    <div class="font-bold">{{ $reservation->user->name }}</div>
                    {{ $reservation->user->email }}<br>
                    <div class="status-badge" style="margin-top: 5px;">Statut : {{ ucfirst($reservation->status) }}</div>
                </td>
            </tr>
        </table>

        <div class="section-title">Détails du séjour</div>
        <div style="padding: 10px 0;">
            <strong class="color-primary">{{ $reservation->residence->nom }}</strong><br>
            <span style="color: #64748b; font-size: 9pt;">{{ $reservation->residence->ville }}, {{ $reservation->residence->pays }}</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Quantité</th>
                    <th class="text-right">Prix Unitaire</th>
                    <th class="text-right">Total HT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="font-bold">Hébergement</div>
                        <span style="font-size: 8pt; color: #64748b;">Du {{ $arrivee->format('d/m/Y') }} au {{ $depart->format('d/m/Y') }}</span>
                    </td>
                    <td class="text-right">{{ str_replace('-', '', number_format($nuits, 0, ',', ' ')) }} nuit(s)</td>
                    <td class="text-right">{{ number_format($reservation->residence->prix_journalier, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right font-bold">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="total-box">
            <table style="width: 100%;">
                <tr>
                    <td style="border: none; padding: 5px 0;" class="font-bold">TOTAL À PAYER</td>
                    <td style="border: none; padding: 5px 0;" class="text-right grand-total">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 60px; font-size: 9pt;">
            <div class="font-bold color-primary" style="margin-bottom: 5px;">Notes importantes :</div>
            <p style="color: #64748b; line-height: 1.4; margin: 0;">
                Cette facture tient lieu de preuve de réservation. Merci de la présenter lors de votre arrivée si nécessaire. 
                Toute annulation est soumise aux conditions générales de vente d'Afrik'Hub.
            </p>
        </div>

        <div class="footer">
            <strong>Afrik'Hub Résidences</strong> — Simplifiez vos séjours en Afrique.<br>
            Document généré automatiquement par notre système le {{ now()->format('d/m/Y à H:i:s') }}.
        </div>
    </div>

</body>
</html>