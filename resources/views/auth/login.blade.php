<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

        <title> {{ config('app.name')}}-Connexion</title>
    </head>
    <body>
        <section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

            <div class="row m-0 col-lg-5 col-xl-4 col-md-6 col-10 shadow-lg border-0 p-4"
                style="backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.342);
                        border-radius:25px;">

                <div class="row g-0 d-flex align-items-center text-center" style="min-height: 100%;">

                    {{-- Logo --}}
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="logo"
                            style="max-width: 130px; filter: drop-shadow(0 5px 12px rgba(0,0,0,0.3));">
                    </div>

                    @include('includes.messages')

                    <form action="{{ route('login.post') }}" method="POST" class="w-100 justify-content-center row m-0">
                        @csrf

                        {{-- Email --}}
                        <div class="form-outline mb-3">
                            <input type="email"
                                class="form-control shadow-sm"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder=" ">
                            <label class="form-label" for="email">Email</label>
                        </div>

                        {{-- Mot de passe --}}
                        <div class="form-outline my-2 position-relative">
                            <input type="password" class="form-control shadow-sm" id="password" name="password" required placeholder=" ">
                            <label class="form-label bg-none" for="password">Mot de passe</label>
                            
                            {{-- L'œil pour masquer/afficher --}}
                            <span id="togglePassword" 
                                style="position: absolute; right: 20px; top: 13px; cursor: pointer; z-index: 10; color: #555;">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>

                        {{-- Lien mot de passe oublié --}}
                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-light underline small fw-light" style="transition:0.3s;">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        {{-- Bouton Connexion --}}
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary w--à w-lg-50 py-2 shadow" style="border-radius:50px; font-size:1.1rem;">
                                Se connecter
                            </button>
                        </div>

                        {{-- Séparateur élégant --}}
                        <div class="text-center mb-3">
                            <span style="font-size:0.9rem; color:#000000;">
                                — ou —
                            </span>
                        </div>

                        {{-- Liens bas --}}
                        <div class="d-flex justify-content-between w-100 mt-3">
                            {{-- Bouton Inscription (flex-grow-1 permet de prendre l'espace disponible) --}}
                            <a class="btn btn-light p-2 shadow-sm me-2 flex-grow-1"
                            style="border-radius:15px;"
                            href="{{ route('register') }}">
                                Inscription
                            </a>

                            {{-- Bouton Accueil --}}
                            <a class="btn btn-dark p-2 shadow-sm flex-grow-1"
                            style="border-radius:15px;"
                            href="{{ route('accueil') }}">
                                Accueil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');
        
            togglePassword.addEventListener('click', function (e) {
                // Basculer le type d'input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Basculer l'icône (œil / œil barré)
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>

    </body>
</html>
