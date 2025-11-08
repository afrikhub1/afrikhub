<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Paiement - Sandbox</title>
    <script src="https://cdn.kkiapay.me/k.js"></script>
</head>

<body>
    <h2>Test Paiement (Sandbox)</h2>

    @if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div style="color:red">{{ session('error') }}</div>
    @endif

    <button id="payer" style="padding:10px;border-radius:6px;background:#0d6efd;color:#fff;border:none;">
        Payer 1000 FCFA (sandbox)
    </button>

    <script>
        document.getElementById('payer').addEventListener('click', function() {
            openKkiapayWidget({
                amount: 1000, // montant en FCFA
                position: "center",
                sandbox: true, // IMPORTANT -> mode test
                key: "{{ config('services.kkiapay.public') }}",
                name: "Test Achat",
                description: "Test sandbox AfrikHub",
                theme: "#0095ff"
            });

            addSuccessListener(function(response) {
                // response.transactionId ou response.transaction_id selon la version
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
                            raw_response: response
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'ok') {
                            window.location.reload();
                        } else {
                            alert('Callback serveur retourné : ' + (data.message || 'Erreur'));
                        }
                    }).catch(err => {
                        console.error(err);
                        alert('Erreur lors de l’appel callback.');
                    });
            });
        });
    </script>
</body>

</html>
