@extends('heritage')
@section('titre', 'connexion')

@section('ux-ui')
<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection

@section('contenu')
<section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

    <div class="card d-flex col-6 shadow-lg border-0"
         style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.15);">

        <div class="row g-0 d-flex align-items-center" style="min-height: 100%;">

            <div class="col-lg-12">
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

        </div>

    </div>

</section>
@endsection
