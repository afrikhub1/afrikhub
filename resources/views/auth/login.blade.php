@extends('heritage')
@section('titre', 'connexion')

@section('ux-ui')
<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection

@section('contenu')

<section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

    <div class="card col-lg-4 col-md-6 col-11 border-0 position-relative"
         style="
            backdrop-filter: blur(18px);
            background: rgba(255,255,255,0.12);
            border-radius: 25px;
            overflow:hidden;
            animation: fadeInUp 1.2s ease both;
            box-shadow:
                0 15px 35px rgba(0,0,0,0.4),
                0 0 20px rgba(0,180,162,0.5);
        ">

        {{-- **Halo neon autour du card** --}}
        <div style="
            position:absolute;
            inset:-2px;
            border-radius:25px;
            padding:2px;
            background: linear-gradient(135deg,#00b4a2,#006d77,#00afb9);
            filter:blur(15px);
            z-index:-1;
        "></div>

        <div class="card-body px-4 py-5">

            {{-- Logo --}}
            <div class="text-center mb-3" style="animation: fadeInUp 1.4s ease;">
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                     style="max-width:150px; filter:drop-shadow(0 8px 20px rgba(0,0,0,0.25));">
            </div>

            {{-- Titre principal --}}
            <h3 class="text-center fw-bold mb-2"
                style="color:#ffffff; text-shadow:0 4px 10px rgba(0,0,0,0.4); letter-spacing:0.5px;">
                Accéder à votre espace
            </h3>

            <p class="text-center mb-4"
               style="color:#cfffff; font-size:0.95rem;">
               Heureux de vous revoir ✨
            </p>

            @include('includes.messages')

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="form-outline mb-3" style="animation: fadeInUp 1.6s ease;">
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
                <div class="form-outline mb-3" style="animation: fadeInUp 1.8s ease;">
                    <input type="password"
                           class="form-control shadow-sm"
                           id="password"
                           name="password"
                           required
                           placeholder=" ">
                    <label class="form-label" for="password">Mot de passe</label>
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}"
                       class="text-muted small"
                       style="transition:.3s;">
                       Mot de passe oublié ?
                    </a>
                </div>

                {{-- Bouton Connexion --}}
                <div class="text-center mb-4" style="animation: fadeInUp 2s ease;">
                    <button type="submit"
                            class="btn btn-primary w-100 py-2 shadow"
                            style="
                                border-radius:50px;
                                font-size:1.1rem;
                                background:linear-gradient(135deg,#006d77,#00b4a2);
                                box-shadow:0 10px 25px rgba(0,180,162,0.45);
                            ">
                        Se connecter
                    </button>
                </div>

                {{-- Séparateur --}}
                <div class="text-center mb-4" style="color:#ddd;">
                    — ou —
                </div>

                {{-- Liens bas --}}
                <div class="d-flex justify-content-between gap-2" style="animation: fadeInUp 2.2s ease;">
                    <a class="btn btn-outline-dark p-2 w-50 shadow-sm"
                       style="border-radius:15px;"
                       href="{{ route('register') }}">
                        Inscription
                    </a>

                    <a class="btn btn-outline-dark p-2 w-50 shadow-sm"
                       style="border-radius:15px;"
                       href="{{ route('accueil') }}">
                        Accueil
                    </a>
                </div>

            </form>
        </div>
    </div>
</section>

@endsection
