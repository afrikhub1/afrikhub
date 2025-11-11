

<!DOCTYPE html>
<html>
<head>
    <title>Vérification de compte</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>
    <p>Merci de vous être inscrit sur notre plateforme !</p>
    <p>Pour activer votre compte, cliquez sur le lien ci-dessous :</p>
    <a href="{{ url('/verify/' . $user->token) }}"
       style="background-color:#f97316;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
        Vérifier mon compte
    </a>

    <p>Si vous n’avez pas créé de compte, ignorez simplement ce message.</p>
</body>
</html>

