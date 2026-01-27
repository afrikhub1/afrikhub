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

    // Calculs corrigés (utilisation de abs() pour éviter les tirets négatifs)
    $arrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
    $depart = \Carbon\Carbon::parse($reservation->date_depart);
    $nuits = abs($depart->diffInDays($arrivee));
    $prixUnitaire = $reservation->residence->prix_journalier;
    $montantTotal = $nuits * $prixUnitaire;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture N°{{ $reservation->id }} — Afrik'Hub</title>
    <style>
        @page { margin: 0cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; padding: 0; color: #1e293b;
            background-color: #ffffff; font-size: 10pt;
        }
        .container { padding: 40px; }
        
        /* IDENTITÉ AFRIK'HUB */
        .brand-stripe {
            height: 10px;
            background: #006d77;
            background: linear-gradient(to right, #006d77, #00afb9);
        }

        .header-table { width: 100%; margin-bottom: 40px; border: none; }
        .color-primary { color: #006d77; }
        
        h1 { font-size: 26pt; margin: 0; color: #006d77; font-weight: bold; }
        
        .section-title {
            background: #f1f5f9;
            padding: 8px 12px;
            border-left: 4px solid #00afb9;
            margin: 20px 0 10px 0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }

        table { width: 100%; border-collapse: collapse; }
        th { 
            text-align: left; padding: 12px; 
            background-color: #f8fafc; color: #475569; 
            font-size: 9pt; border-bottom: 1px solid #e2e8f0;
        }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .total-wrapper {
            margin-top: 30px;
            width: 45%;
            margin-left: 55%;
        }
        
        .total-row {
            background: #006d77;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 14pt;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #64748b;
            padding-top: 20px;
        }

        .info-label { color: #94a3b8; font-size: 8pt; text-transform: uppercase; margin-bottom: 3px; }
    </style>
</head>
<body>

    <div class="brand-stripe"></div>

    <div class="container">
        <table class="header-table">
            <tr>
                <td style="width: 50%; border: none;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" style="width: 160px;">
                    @else
                        <h1 style="color:#006d77;">Afrik'Hub</h1>
                    @endif
                </td>
                <td style="width: 50%; border: none; text-align: right;">
                    <div style="font-size: 20pt; font-weight: bold; color: #006d77;">FACTURE</div>
                    <div style="color: #64748b; margin-top: 5px;">
                        Référence : <strong>#{{ $reservation->reservation_code ?? $reservation->id }}</strong><br>
                        Date d'émission : {{ now()->format('d/m/Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%; border: none; vertical-align: top;">
                    <div class="info-label">Éditeur & Prestataire</div>
                    <div class="font-bold" style="color:#006d77; font-size: 11pt;">Afrik’Hub Location</div>
                    <div style="line-height: 1.5;">
                        Services immobiliers et automobiles<br>
                        Abidjan, Cocody – Côte d’Ivoire<br>
                        <strong>Contact :</strong> afrikhub1@gmail.com<br>
                        <strong>Tél :</strong> +225 01 03 09 06 16
                    </div>
                </td>
                <td style="width: 50%; border: none; text-align: right; vertical-align: top;">
                    <div class="info-label">Client</div>
                    <div class="font-bold" style="font-size: 11pt;">{{ $reservation->user->name }}</div>
                    <div style="line-height: 1.5;">
                        {{ $reservation->user->email }}<br>

                        @php
                            $statusBrut = $reservation->status;
                            // On force le statut en majuscule proprement
                            $statusMaj = mb_strtoupper($statusBrut, 'UTF-8');
                        @endphp
                        Statut : <strong>{{ $statusMaj }}</strong>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">Détails de la réservation</div>
        <div style="padding: 10px 0 20px 0;">
            <div class="font-bold" style="font-size: 12pt;">{{ $reservation->residence->nom }}</div>
            <div style="color: #64748b;">{{ $reservation->residence->ville }}, {{ $reservation->residence->pays }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description du service</th>
                    <th class="text-right">Séjour</th>
                    <th class="text-right">Prix / Nuit</th>
                    <th class="text-right">Total HT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 40%;">
                        <strong>Hébergement résidentiel</strong><br>
                        <span style="font-size: 8pt; color: #64748b;">Période du {{ $arrivee->format('d/m/Y') }} au {{ $depart->format('d/m/Y') }}</span>
                    </td>
                    <td class="text-right">{{ number_format($nuits, 0, ',', ' ') }} nuit(s)</td>
                    <td class="text-right">{{ number_format($prixUnitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right font-bold">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="total-wrapper">
            <div class="total-row">
                <span style="font-size: 9pt; font-weight: normal; float: left; margin-top: 5px;">NET À PAYER</span>
                {{ number_format($montantTotal, 0, ',', ' ') }} FCFA
            </div>
        </div>

        <div style="margin-top: 60px;">
            <div class="font-bold color-primary" style="margin-bottom: 5px; font-size: 9pt;">Conditions de règlement</div>
            <p style="color: #64748b; line-height: 1.4; margin: 0; font-size: 8.5pt;">
                Responsable de publication : Direction Afrik’Hub. <br>
                Ce document est une facture officielle. Le règlement s'effectue selon les modalités choisies lors de la réservation. 
                En cas de litige, les tribunaux d'Abidjan sont seuls compétents.
            </p>
        </div>

        <div class="footer">
            <div style="margin-bottom: 5px; font-weight: bold;">Afrik’Hub Location — Abidjan, Côte d’Ivoire</div>
            Merci de votre confiance. Facture générée le {{ now()->format('d/m/Y à H:i:s') }}.
        </div>
    </div>

</body>
</html>