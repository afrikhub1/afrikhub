@extends('heritage')
@section('titre', 'connexion')

@section('ux-ui')
<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection

@section('contenu')

<section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

    <div class="row m-0 col-lg-3 col-md-5 col-10 shadow-lg border-0 p-4"
         style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.15);
                border-radius:25px;">

        <div class="row g-4 d-flex align-items-center text-center" style="min-height: 100%;">

            {{-- Logo --}}
            <div class="mb-4 d-flex justify-content-center">
                <img src="{{ asset('assets/images/logo_01.png') }}" alt="logo"
                     style="max-width: 130px; filter: drop-shadow(0 5px 12px rgba(0,0,0,0.3));">
            </div>

            {{-- Titre stylé --}}
            <h3 class="fw-bold mb-2"
                style="color:#006d77; letter-spacing:1px; text-transform:uppercase;">
                Accéder à votre espace
            </h3>

            <p class="mb-4" style="color:#009688;">
                Heureux de vous revoir ✨
            </p>

            @include('includes.messages')

            <form action="{{ route('login.post') }}" method="POST" class="w-100">
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
                <div class="form-outline mb-2">
                    <input type="password"
                           class="form-control shadow-sm"
                           id="password"
                           name="password"
                           required
                           placeholder=" ">
                    <label class="form-label" for="password">Mot de passe</label>
                </div>

                {{-- Lien mot de passe oublié --}}
                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}"
                       class="text-muted small"
                       style="transition:0.3s;">
                        Mot de passe oublié ?
                    </a>
                </div>

                {{-- Bouton Connexion --}}
                <div class="text-center mb-4">
                    <button type="submit"
                            class="btn btn-primary w-100 py-2 shadow"
                            style="border-radius:50px; font-size:1.1rem;">
                        Se connecter
                    </button>
                </div>

                {{-- Séparateur élégant --}}
                <div class="text-center mb-3">
                    <span style="font-size:0.9rem; color:#ddd;">
                        — ou —
                    </span>
                </div>

                {{-- Liens bas --}}
                <div class="d-flex justify-content-between">
                    <a class="btn btn-outline-light p-2 w-48 shadow-sm"
                       style="border-radius:15px;"
                       href="{{ route('register') }}">
                        Inscription
                    </a>

                    <a class="btn btn-outline-light p-2 w-48 shadow-sm"
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
