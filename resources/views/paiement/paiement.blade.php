<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .payment-btn {
            min-width: 120px;
            font-weight: bold;
        }
        #qrDisplay img {
            max-height: 300px;
        }
        #qrDisplay {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Choisissez votre méthode de paiement</h2>

    <!-- Boutons des paiements -->
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        @php
            $paiements = ['Moov', 'MTN', 'Orange', 'Wave'];
        @endphp

        @foreach($paiements as $pay)
            <button class="btn btn-primary payment-btn" data-pay="{{ strtolower($pay) }}">{{ $pay }}</button>
        @endforeach
    </div>

    <!-- Affichage du QR code -->
    <div id="qrDisplay">
        <p class="text-muted mt-3">Cliquez sur un bouton pour afficher le QR code</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const qrDisplay = document.getElementById('qrDisplay');

    document.querySelectorAll('.payment-btn').forEach(button => {
        button.addEventListener('click', () => {
            const service = button.getAttribute('data-pay');
            const imgPath = `/assets/paiement/code_qr/${service}.jpg`; // Assurez-vous que les fichiers sont nommés moov.jpg, mtn.jpg, orange.jpg, wave.jpg

            qrDisplay.innerHTML = `
                <h4>${service.toUpperCase()}</h4>
                <img src="${imgPath}" alt="QR Code ${service}" class="img-fluid rounded shadow">
                <p class="mt-2">Scannez ce QR code avec votre application ${service} pour effectuer le paiement.</p>
            `;
        });
    });
</script>
</body>
</html>
