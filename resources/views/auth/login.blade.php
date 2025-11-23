@extends('heritage')
@section('titre', 'connexion')

@section('ux-ui')
<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection

@section('contenu')
<section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

    <div class="card d-flex shadow-lg border-0"
         style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.15);">

        <div class="row g-0 d-flex align-items-center" style="min-height: 100%;">

            {{-- COL GAUCHE - FORMULAIRE --}}
            <div class="col-lg-6">
                <div class="card-body">

                    {{-- Logo --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                             style="max-width: 160px; filter: drop-shadow(0 5px 12px rgba(0,0,0,0.2));">
                    </div>

                    {{-- Titre stylé --}}
                    <h3 class="text-center fw-bold mb-2"
                        style="color:#006d77; letter-spacing:1px; text-transform:uppercase;">
                        Accéder à votre espace
                    </h3>

                    <p class="text-center mb-4" style="color:#009688;">
                        Heureux de vous revoir ✨
                    </p>

                    @include('includes.messages')

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        {{-- Email --}}
                        <div class="form-outline">
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
                        <div class="form-outline">
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
                        <div class="text-center mb-4">
                            <span style="font-size:0.9rem; color:#777;">
                                — ou —
                            </span>
                        </div>

                        {{-- Liens bas --}}
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-outline-dark p-2 w-48 shadow-sm"
                               style="border-radius:15px;"
                               href="{{ route('register') }}">
                                Inscription
                            </a>

                            <a class="btn btn-outline-dark p-2 w-48 shadow-sm"
                               style="border-radius:15px;"
                               href="{{ route('accueil') }}">
                                Accueil
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- COL DROITE --}}
            <div class="col-lg-6 gradient-custom-2"
                 style="padding:3rem; text-align:center;">

                <div style="animation: fadeInRight 1.2s ease;">
                    <h2 class="fw-bold mb-3" style="text-shadow:0 3px 10px rgba(0,0,0,0.3);">
                        Bienvenue dans votre espace
                    </h2>

                    <p style="font-size:1.05rem; line-height:1.7;">
                        Recherchez, réservez et gérez vos hébergements en toute simplicité.<br>
                        Votre confort, notre priorité 🌿
                    </p>

                    {{-- Effet icône animée --}}
                    <div class="mt-4">
                        <i class="fa-solid fa-house-chimney-user"
                           style="font-size:3.2rem; opacity:0.9; filter:drop-shadow(0 6px 12px rgba(0,0,0,0.3));"></i>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
@endsection
