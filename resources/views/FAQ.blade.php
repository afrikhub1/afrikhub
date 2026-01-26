<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Afrik’Hub Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .faq-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative; /* Important pour le positionnement du bouton si besoin */
        }

        /* Style du bouton Retour */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .btn-back:hover {
            color: #0d6efd;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 30px;
            color: #0d6efd;
            font-weight: 800;
        }

        .faq-question {
            cursor: pointer;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            position: relative;
            font-weight: bold;
            background-color: #f1f1f1;
            font-size: 1.1rem;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .faq-question:hover {
            background-color: #e9ecef;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 0 0 8px 8px;
        }

        .faq-question::after {
            content: '\f067'; /* Code FontAwesome pour + */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            font-size: 1rem;
            transition: transform 0.3s;
        }

        .faq-question.active::after {
            content: '\f068'; /* Code FontAwesome pour - */
        }
    </style>
</head>
<body>

<div class="faq-container">
    <a href="javascript:history.back()" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
    </a>

    <h2 class="faq-header text-uppercase">FAQ - Questions fréquentes</h2>

    <div class="faq-item">
        <div class="faq-question">Comment mettre ma résidence en location ?</div>
        <div class="faq-answer">
            Vous pouvez ajouter votre résidence via notre interface dédiée aux propriétaires,
            en remplissant le formulaire complet avec toutes les informations et commodités.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">Quels types de résidences puis-je publier ?</div>
        <div class="faq-answer">
            Nous acceptons tous types de résidences : appartements, villas, studios, maisons individuelles.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">Comment sont gérées les réservations ?</div>
        <div class="faq-answer">
            Les réservations sont validées par le propriétaire. Vous recevrez une notification par email et via notre plateforme.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">Quels moyens de paiement sont acceptés ?</div>
        <div class="faq-answer">
            Nous acceptons les paiements via Moov, MTN, Orange, Wave, Visa ou virement bancaire direct.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">Comment contacter l’assistance ?</div>
        <div class="faq-answer">
            Vous pouvez nous écrire à <a href="mailto:afrikhub1@gmail.com" class="text-decoration-none">afrikhub1@gmail.com</a> ou nous appeler au +225 01 03 09 06 16.
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.faq-question').click(function(){
            // Fermer les autres réponses ouvertes (optionnel, pour un effet accordéon)
            $('.faq-answer').not($(this).next()).slideUp();
            $('.faq-question').not($(this)).removeClass('active');

            $(this).toggleClass('active');
            $(this).next('.faq-answer').slideToggle();
        });
    });
</script>

</body>
</html>