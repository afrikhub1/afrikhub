
<div id="carouselExample" class="carousel slide col-10 col-md-6 col-lg-6 m-0" data-bs-ride="carousel">
                    {{-- Indicateurs --}}
                    <div class="carousel-indicators">
                        @foreach($carousels as $key => $carousel)
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded" style="max-height: 400px; height: 400px;">
                        @forelse($carousels as $key => $carousel)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }} p-0" style="max-height: 400px; height: 400px;">
                                <div>
                                    @if($carousel->lien)
                                        {{-- On vérifie si le lien commence par http, sinon on peut l'ajouter ou s'assurer que la donnée en BD est propre --}}
                                        <a href="{{ str_starts_with($carousel->lien, 'http') ? $carousel->lien : 'https://' . $carousel->lien }}" target="_blank">
                                    @endif

                                    <img src="{{ $carousel->image_url }}" class="d-block w-100" alt="Publicité"
                                        style="object-fit: cover;">
                                    @if($carousel->lien)
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/flyer.jpeg') }}" class="d-block w-100" alt="Bienvenue"
                                    style="height: 400px; object-fit: cover;">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                                    <h5>Bienvenue sur Afrikhub</h5>
                                    <p>Découvrez nos services d'hébergement.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Boutons précédent / suivant --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
