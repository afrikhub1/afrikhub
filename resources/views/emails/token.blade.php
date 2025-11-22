<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de compte</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

    <table align="center" width="600" cellpadding="0" cellspacing="0"
           style="background:#ffffff; border-radius:8px; padding:20px;">
        <tr>
            <td>
                <h2 style="color:#333;">Bienvenue {{ $user->name }} !</h2>

                <p>
                    Merci de vous être inscrit sur <strong>Afrik'Hub</strong>.
                    Cliquez sur le bouton ci-dessous pour activer votre compte :
                </p>

                <p style="text-align:center; margin:30px 0;">
                    <a href="{{ url('/verify/' . $user->token . '?email=' . urlencode($user->email)) }}"
                    style="background:#ff8c00; color:white; padding:12px 20px;
                            text-decoration:none; border-radius:5px; font-weight:bold;">
                        Vérifier mon compte
                    </a>

                </p>

                <p>
                    Si vous n’êtes pas à l’origine de cette inscription, ignorez ce message.
                </p>

                <p style="margin-top:20px;">
                    — L’équipe Afrik'Hub
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
