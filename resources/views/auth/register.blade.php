<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ config('app.name') }}-Inscription</title>
</head>
<body class="bg-gray-50">

    <header class="navbar navbar-expand-lg px-4 py-3 mb-4 bg-indigo-600">
        <div class="container-fluid">
            <div class="col-6 col-md-3">
                <a class="navbar-brand fw-bold text-light" href="#">
                    <i class="fas fa-user-plus me-2"></i>Inscription
                </a>
            </div>
            <div class="col-6 col-md-9 d-flex justify-content-end gap-2">
                <a href="{{ route('accueil') }}" class="btn btn-outline-light btn-sm">Accueil</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Se connecter</a>
            </div>
        </div>
    </header>

    <div class="container mt-2">
        <h2 class="mb-4 text-3xl font-bold text-gray-800 text-center">Formulaire d'inscription</h2>

        @if ($errors->any())
            <div class="alert alert-danger text-center shadow-sm">
                <strong>Erreur de validation !</strong> Veuillez corriger les champs ci-dessous.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="row g-3 p-4 bg-white rounded-xl shadow-lg needs-validation">
            @csrf

            <div class="col-12 col-md-6">
                <label for="nom" class="form-label font-semibold">Nom complet</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required placeholder="John Doe"/>
                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="email" class="form-label font-semibold">Adresse e-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="exemple@mail.com"/>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="password" class="form-label font-semibold">Mot de passe</label>
                <div class="relative flex items-center">
                    <input type="password" class="form-control pr-10 @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Ex: Harry@234"/>
                    <span class="absolute right-3 cursor-pointer text-gray-500 hover:text-indigo-600" onclick="toggleVisibility('password', 'eye1')">
                        <i class="fas fa-eye" id="eye1"></i>
                    </span>
                </div>
                <small class="text-indigo-600 italic block mt-1">Min. 8 carac. (Majuscule, Chiffre, Spécial)</small>
                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="password_confirmation" class="form-label font-semibold">Confirmez le mot de passe</label>
                <div class="relative flex items-center">
                    <input type="password" class="form-control pr-10" id="password_confirmation" name="password_confirmation" required placeholder="Confirmez votre mot de passe"/>
                    <span class="absolute right-3 cursor-pointer text-gray-500 hover:text-indigo-600" onclick="toggleVisibility('password_confirmation', 'eye2')">
                        <i class="fas fa-eye" id="eye2"></i>
                    </span>
                </div>
            </div>

            <div class="col-12">
                <label for="contact" class="form-label font-semibold">Numéro de téléphone</label>
                <input type="tel" class="form-control @error('contact') is-invalid @enderror" id="phone" name="contact" value="{{ old('contact') }}" required placeholder="+225 01 02 03 04 05"/>
                @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="ville" class="form-label font-semibold">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="{{ old('ville') }}" required placeholder="Abidjan"/>
            </div>
            <div class="col-md-6">
                <label for="pays" class="form-label font-semibold">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays" value="{{ old('pays') }}" required placeholder="Côte d'Ivoire"/>
            </div>

            <div class="col-md-6">
                <label for="type_compte" class="form-label font-semibold">Type de compte</label>
                <select class="form-select @error('type_compte') is-invalid @enderror" id="type_compte" name="type_compte" required>
                    <option value="">-- sélectionnez --</option>
                    <option value="client" {{ old('type_compte')=='client' ? 'selected' : '' }}>Client</option>
                    <option value="professionnel" {{ old('type_compte')=='professionnel' ? 'selected' : '' }}>Professionnel</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="adresse" class="form-label font-semibold">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse') }}" required placeholder="Cocody, Cité des arts"/>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="cgu" name="cgu" required/>
                    <label class="form-check-label text-gray-600" for="cgu">
                        J’accepte les <a class="text-indigo-600 underline" href="{{ route('politique_confidentialite') }}">conditions générales d’utilisation</a>.
                    </label>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-6 w-full">
                <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all transform active:scale-95">
                    S’inscrire maintenant
                </button>
                
                <a href="{{ route('login') }}" class="w-full md:w-auto text-center border-2 border-gray-800 text-gray-800 font-bold py-3 px-8 rounded-xl hover:bg-gray-800 hover:text-white transition-all">
                    Se connecter
                </a>

                <button type="button" onclick="history.back()" class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </button>
            </div>
        </form>
    </div>

    <script>
        // Fonction pour basculer l'oeil
        function toggleVisibility(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (input.type === "password") {
                input.type = "text";
                eye.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                eye.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // Validation Bootstrap
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>