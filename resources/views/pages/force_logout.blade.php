<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url={{ $redirect }}">
    <title>Redirection...</title>
    <script>
        // Force un redirect immédiat
        setTimeout(function() {
            window.location.href = "{{ $redirect }}";
        }, 500);
    </script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="p-6 bg-white shadow rounded text-center">
        <h1 class="text-lg font-bold mb-2">Déconnexion</h1>
        <p>{{ $message }}</p>
        <p class="mt-4 text-sm text-gray-500">Redirection vers la page de connexion...</p>
    </div>
</body>
</html>
