<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de compte</title>
</head>
<body style="font-family:Arial,sans-serif;line-height:1.6;color:#333;">
    <h2>Bonjour {{ $user->name }},</h2>

    <p>Merci de vous être inscrit sur notre plateforme !</p>
    <p>Pour activer votre compte, cliquez sur le bouton ci-dessous :</p>

    <a href="{{ url('/verify/' . $user->token) }}"
       style="display:inline-block;background-color:#f97316;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;font-weight:bold;">
        Vérifier mon compte
    </a>

    <p style="margin-top:20px;">Si vous n’avez pas créé de compte, ignorez simplement ce message.</p>
</body>
</html>
