<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales - Afrik’Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
        }

        /* Bouton Retour */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #1a73e8;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 25px;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: #0d47a1;
            transform: translateX(-5px);
        }

        h1, h2 {
            color: #1a73e8;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2 i {
            font-size: 1.2rem;
        }

        p, ul {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
        }

        ul li::before {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #1a73e8;
        }

        .info-card {
            background-color: #f8faff;
            border: 1px solid #e1e8f5;
            padding: 20px;
            border-radius: 10px;
        }

        hr {
            border: 0;
            height: 1px;
            background: #eee;
            margin: 40px 0;
        }

        .faq-box {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .faq-box strong {
            color: #1a73e8;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>

        <h1>Mentions Légales & Informations</h1>

        <h2><i class="fas fa-building"></i> 1. Édition du site</h2>
        <div class="info-card">
            <p>
                Le présent site est édité par :<br>
                <strong>Afrik’Hub Location</strong>, société de services technologiques.<br>
                Siège social : Abidjan, Cocody – Côte d’Ivoire<br>
                Contact : <a href="mailto:afrikhub1@gmail.com">afrikhub1@gmail.com</a> – +225 01 03 09 06 16<br>
                Responsable de publication : Direction Afrik’Hub
            </p>
        </div>

        <h2><i class="fas fa-user-lock"></i> 2. Politique de confidentialité</h2>
        <p>
            Nous collectons vos données (nom, contact, historique) pour assurer le bon fonctionnement de vos réservations.
        </p>
        <ul>
            <li>Traitement sécurisé des réservations et paiements.</li>
            <li>Mise en relation directe avec les propriétaires.</li>
            <li>Prévention des fraudes et sécurité des comptes.</li>
            <li>Envoi des confirmations par Email / SMS / WhatsApp.</li>
        </ul>
        <p><strong>Vos droits :</strong> Vous disposez d’un droit d’accès et de suppression de vos données via <a href="mailto:afrikhub1@gmail.com">afrikhub1@gmail.com</a>.</p>

        <hr>

        <h2><i class="fas fa-headset"></i> 3. Support technique</h2>
        <p>Notre équipe vous assiste pour tout problème lié à votre compte ou vos annonces :</p>
        <ul>
            <li>Assistance au paiement et facturation.</li>
            <li>Aide à la mise en ligne d'annonces propriétaires.</li>
            <li>Problèmes de connexion ou bugs techniques.</li>
        </ul>
        <p>Délai de réponse moyen : <strong>24 heures ouvrées.</strong></p>

        <hr>

        <h2><i class="fas fa-question-circle"></i> 4. FAQ Express</h2>
        <div class="faq-box">
            <p><strong>Q : Comment réserver ?</strong><br>
            R : Choisissez votre bien, sélectionnez les dates et procédez au paiement sécurisé.</p>
        </div>
        <div class="faq-box">
            <p><strong>Q : Est-ce sécurisé ?</strong><br>
            R : Oui, nous utilisons le cryptage SSL et des passerelles de paiement certifiées.</p>
        </div>

        <hr>

        <h2><i class="fas fa-gavel"></i> 5. Conditions de Publication</h2>
        <p>Pour déposer une annonce, le propriétaire s'engage à :</p>
        <ul>
            <li>Fournir des visuels réels et non trompeurs du bien.</li>
            <li>Être le propriétaire légal ou mandataire autorisé.</li>
            <li>Répondre aux demandes de réservation dans un délai raisonnable.</li>
        </ul>
        <p><em>Afrik’Hub se réserve le droit de supprimer toute annonce jugée frauduleuse sans préavis.</em></p>
    </div>

    <footer style="text-align: center; padding: 30px; color: #888;">
        &copy; 2026 Afrik’Hub Location — Abidjan, Côte d'Ivoire.
    </footer>
</body>
</html>