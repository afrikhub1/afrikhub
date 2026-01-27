<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/inscription.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

        <title> {{ config('app.name')}}-Connexion</title>
    </head>
    <body>

        <header class="navbar navbar-expand-lg px-4 py-3 mb-4">
            <div class="container-fluid">
                <!-- Logo / Titre -->
                <div class="col-6 col-md-3">
                    <a class="navbar-brand fw-bold text-light" href="#">
                        <i class="fas fa-user-plus me-2"></i>Inscription
                    </a>
                </div>

                <!-- Menu responsive -->
                <div class="col-6 col-md-9 d-flex justify-content-end align-items-center position-relative">
                    <input type="checkbox" id="menuToggle" class="d-none" />
                    <label for="menuToggle" class="menu-label d-md-none"><i class="fas fa-bars"></i></label>
                    <div id="menu" class="menu-links mt-2 mt-md-0 text-center">
                        <a href="{{ route('accueil') }}" class="btn btn-outline-light">Accueil</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Se connecter</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mt-2">
            <h2 class="mb-4 text-3xl">Formulaire d'inscription</h2>

            <!-- Affichage général des erreurs (si besoin d'un résumé, sinon les messages sous les champs suffisent) -->
            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    <strong>Erreur de validation !</strong> Veuillez corriger les champs en rouge ci-dessous.
                </div>
            @endif

            <!-- Formulaire principal -->
            <form method="POST" action="{{ route('register') }}" class="row g-3 p-4 rounded shadow-sm needs-validation">
                @csrf

                <!-- Nom complet -->
                <div class="col-12 col-md-6">
                    <label for="name" class="form-label">Nom complet</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" required placeholder="John Doe"/>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez entrer votre nom complet.</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-12 col-md-6">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required placeholder="exemple@mail.com"/>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="col-12 col-md-6 position-relative">
                    <label for="password" class="form-label">Mot de passe</label>

                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror pe-5"
                        id="password"
                        name="password"
                        required
                        placeholder="Ex: Harry@234"
                    />

                    <span
                        class="position-absolute top-13px end-0 translate-middle-y me-3 cursor-pointer text-gray-500 hover:text-indigo-600"
                        onclick="toggleVisibility('password', 'eye1')"
                    >
                        <i class="fas fa-eye" id="eye1"></i>
                    </span>

                    <p class="font-bold mb-1 text-warning" style="font-style: oblique">
                        Au moins 8 caractères - majuscule - chiffre - caractère spécial. Ex: mon@Mot123
                    </p>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez saisir un mot de passe.</div>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="col-12 col-md-6">
                    <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                        name="password_confirmation" required placeholder="Confirmez votre mot de passe"/>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez confirmer le mot de passe.</div>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="col-12">
                    <label for="contact" class="form-label">Numéro de téléphone</label>
                    <input type="tel" class="form-control @error('contact') is-invalid @enderror" id="phone" name="contact"
                        value="{{ old('contact') }}" pattern="^\+?[0-9\s\-]{7,15}$"
                        required placeholder="+225 01 23 45 67"/>
                    @error('contact')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez entrer un numéro valide.</div>
                    @enderror
                </div>

                <!-- Ville -->
                <div class="col-md-6">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville"
                        value="{{ old('ville') }}" required placeholder="Abidjan"/>
                    @error('ville')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez indiquer une ville.</div>
                    @enderror
                </div>

                <!-- Pays -->
                <div class="col-md-6">
                    <label for="pays" class="form-label">Pays</label>
                    <input type="text" class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays"
                        value="{{ old('pays') }}" required placeholder="Côte d'Ivoire"/>
                    @error('pays')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez indiquer un pays.</div>
                    @enderror
                </div>

                <!-- Type de compte -->
                <div class="col-md-6">
                    <label for="type_compte" class="form-label">Type de compte</label>
                    <select class="form-select @error('type_compte') is-invalid @enderror" id="type_compte" name="type_compte"  required>
                        <option value="" >-- sélectionnez un type de compte --</option>
                        <option value="client" {{ old('type_compte')=='client' ? 'selected' : '' }}>Client</option>
                        <option value="professionnel" {{ old('type_compte')=='professionnel' ? 'selected' : '' }}>Professionnel</option>
                    </select>
                    @error('type_compte')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez choisir un type de compte.</div>
                    @enderror
                </div>

                <!-- Adresse -->
                <div class="col-md-6">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse"
                        value="{{ old('adresse') }}" required placeholder="Ex: Cocody cité des arts"/>
                    @error('adresse')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="invalid-feedback">Veuillez indiquer votre adresse.</div>
                    @enderror
                </div>

                <!-- Acceptation CGU -->
                <div class="col-12">
                    <div class="form-check @error('cgu') is-invalid @enderror">
                        <input class="form-check-input @error('cgu') is-invalid @enderror" type="checkbox" id="cgu" name="cgu" required/>
                        <label class="form-check-label" for="cgu">
                            J’accepte les conditions générales d’utilisation.  <a class="text-warning fw-light" href="{{ route('politique_confidentialite') }}">Lire</a>
                        </label>
                        @error('cgu')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @else
                            <div class="invalid-feedback">Vous devez accepter les conditions.</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-3 w-100">
                    {{-- Bouton S'inscrire --}}
                    <button type="submit" class="btn btn-light shadow w-100 w-md-auto" name="valider">
                        S’inscrire
                    </button>
                    {{-- Bouton Se connecter --}}
                    <a href="{{ route('login') }}" class="btn btn-dark w-100 w-md-auto">
                        Se connecter
                    </a>
                    {{-- Bouton Accueil --}}
                    <a href="{{ route('accueil') }}" class="btn btn-primary w-100 w-md-auto">
                        Accueil
                    </a>
                </div>
            </form>
        </div>


        <script>
            // Validation bootstrap personnalisée
            (function() {
                'use strict';
                const forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        // Cette partie gère uniquement la validation côté client (HTML required)
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        </script>

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
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
