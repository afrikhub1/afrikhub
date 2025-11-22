@extends('heritage')
@section('titre', 'connexion')

@section('ux-ui')
<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection

@section('contenu')
<section class="min-vh-100 d-flex justify-content-center align-items-center w-100">

    <div class="card">

        <div class="row g-0">

            {{-- COL GAUCHE - FORMULAIRE --}}
            <div class="card d-flex">
                <div class="row g-0 d-flex align-items-center" style="min-height: 100%;">


                    {{-- Logo --}}
                    <div class="text-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    </div>

                    <p class="text-center">Connexion à votre espace</p>

                    @include('includes.messages')

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        {{-- Email --}}
                        <div class="form-outline">
                            <input type="email"
                                   class="form-control"
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
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   required
                                   placeholder=" ">

                            <label class="form-label" for="password">Mot de passe</label>
                        </div>

                        {{-- Lien mot de passe oublié --}}
                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-muted small">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        {{-- Bouton Connexion --}}
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Se connecter
                            </button>
                        </div>

                        {{-- Liens bas --}}
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-outline-dark p-2 w-48" href="{{ route('register') }}">
                                Inscription
                            </a>

                            <a class="btn btn-outline-dark p-2 w-48" href="{{ route('accueil') }}">
                                Accueil
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            {{-- COL DROITE --}}
            <div class="col-lg-6 gradient-custom-2">
                <div>
                    <h4>Trouvez votre hébergement idéal</h4>
                    <p>
                        Résidences de vacances, séjours courts ou hébergements longue durée —
                        notre plateforme vous connecte aux meilleures offres disponibles.
                    </p>
                </div>
            </div>

        </div>

    </div>

</section>
@endsection
