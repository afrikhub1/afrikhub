<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payer la facture</title>
    <script src="https://cdn.kkiapay.me/k.js"></script>
</head>
<body>
    <h2>Paiement de la réservation #{{ $reservation->id }}</h2>

    @if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div style="color:red">{{ session('error') }}</div>
    @endif

    <button id="payer" style="padding:10px;border-radius:6px;background:#0d6efd;color:#fff;border:none;">
        Payer {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
    </button>

    <script>
        document.getElementById('payer').addEventListener('click', function() {
            openKkiapayWidget({
                amount: {{ $reservation->total }},
                position: "center",
                sandbox: true, // mettre false en production
                key: "{{ config('services.kkiapay.public') }}",
                name: "AfrikHub",
                description: "Paiement réservation #{{ $reservation->id }}",
                theme: "#0095ff"
            });

            addSuccessListener(function(response) {
                const transactionId = response.transactionId || response.transaction_id || null;
                if (!transactionId) {
                    alert('Aucun transactionId reçu du widget.');
                    return;
                }

                fetch("{{ route('paiement.callback') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        transaction_id: transactionId,
                        reservation_id: {{ $reservation->id }},
                        raw_response: response
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'ok') {
                        alert('Paiement réussi !');
                        window.location.href = "{{ route('historique') }}";
                    } else {
                        alert('Erreur : ' + (data.message || 'Paiement échoué'));
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Erreur lors du callback serveur.');
                });
            });
        });
    </script>
</body>
</html>
