<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interrompre le séjour</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Interrompre votre séjour</h1>

        <p class="mb-4 text-gray-600">Résidence : <span class="font-semibold text-gray-900">{{ $residence->nom }}</span></p>
        <p class="mb-6 text-gray-500">En cliquant sur le bouton ci-dessous, vous envoyez une demande pour libérer cette résidence.</p>

        <form action="{{ route('sejour.demander', $residence->id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                Interrompre le séjour
            </button>
        </form>


        <a href="{{ url()->previous() }}" class="block mt-4 text-sm text-gray-600 hover:text-gray-900">Retour</a>
    </div>

</body>
</html>
