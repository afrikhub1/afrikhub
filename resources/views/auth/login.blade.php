@extends('heritage')
@section('titre', 'connexion')
@section('ux-ui')
    <link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">
@endsection
@section('contenu')
    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">

                            <!-- LEFT FORM -->
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="../../public/logo/logo.png" alt="logo">
                                    </div>

                                    <form action="{{ route('login.post') }}" method="POST">

                                        @csrf

                                        <p>Me connecter à mon compte</p>

                                        @error('email')
                                            <div class='alert alert-danger text-center' role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        @error('password')
                                            <div class='alert alert-danger text-center' role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="form-outline mb-4">
                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" class="form-control" name="password" id="mots_de_passe" required />
                                            <label class="form-label" for="password">Mot de passe</label>
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <input class="btn btn-primary btn-block mb-3 me-3" type="submit" name="connexion" value="Se connecter"> <br>
                                            <a class="text-muted" href="mots_de_passe_restor.php">Mot de passe oublié ?</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between pb-4">
                                            <a class="btn btn-outline-danger p-2 text-dark text-decoration-none" href="{{ route('register') }}">Inscription</a>
                                            <a class="btn btn-outline-success p-2 text-dark text-decoration-none" href="{{ route('accueil') }}">Accueil</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- RIGHT INFO -->
                                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                        <h4 class="mb-4">Trouvez l’hébergement qui vous ressemble</h4>
                                        <p class="small mb-0">
                                        Que vous cherchiez une résidence de vacances, un logement pour un court séjour ou un hébergement longue durée,
                                        notre plateforme vous connecte aux meilleures offres disponibles.
                                        Réservez en toute simplicité et profitez d’un confort adapté à vos besoins.
                                        </p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
