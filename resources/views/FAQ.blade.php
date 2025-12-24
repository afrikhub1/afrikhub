<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Afrik’Hub Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .faq-header {
            text-align: center;
            margin-bottom: 30px;
            color: #0d6efd;
        }

        .faq-question {
            cursor: pointer;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            position: relative;
            font-weight: bold;
            background-color: #f1f1f1;
            font-size: 1.2rem;
        }

        .faq-question:hover {
            background-color: #f8f9fa;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        .faq-question::after {
            content: '+';
            position: absolute;
            right: 20px;
            font-size: 1.5rem;
            transition: transform 0.3s;
        }

        .faq-question.active::after {
            content: '-';
        }
    </style>
</head>
<body>

<div class="faq-container">
    <h2 class="faq-header">FAQ - Questions fréquentes</h2>

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
            Vous pouvez nous écrire à <a href="mailto:afrikhub1@gmail.com">afrikhub1@gmail.com</a> ou nous appeler au +225 01 03 09 06 16.
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.faq-question').click(function(){
            $(this).toggleClass('active');
            $(this).next('.faq-answer').slideToggle();
        });
    });
</script>

</body>
</html>
