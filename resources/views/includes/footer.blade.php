<footer class="border-t border-indigo-700 m-0 text-white" style="background: linear-gradient(135deg, #006d77, #00afb9);">
    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-700 pb-10 text-center md:text-left">
            
            {{-- Colonne 1 : Logo & Slogan --}}
            <div class="space-y-4">
                <h3 class="text-xl font-bold text-indigo-400">Afrik'Hub</h3>
                <p class="text-xs md:text-sm text-gray-400 leading-relaxed max-w-xs mx-auto md:mx-0">
                    Votre Hub de Résidences en Afrique.
                </p>

                <div class="flex items-center justify-center md:justify-start text-gray-400">
                    <i class="fa fa-phone text-xs me-3"></i>
                    <span class="text-xs md:text-sm">+225 01 03 09 06 16</span>
                </div>

                {{-- Réseaux Sociaux : justify-center sur mobile --}}
                <div class="flex justify-center md:justify-start space-x-4 pt-2">
                    <a href="https://www.facebook.com/share/1KgiASzTSe/" class="text-gray-400 hover:text-indigo-400 transition text-lg" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@afrikhub5?_r=1&_t=ZM-92UhuMQAC3I" class="text-gray-400 hover:text-indigo-400 transition text-lg" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/afrikhub2025?igsh=N25qeDltY2U3Mjdy" class="text-gray-400 hover:text-indigo-400 transition text-lg" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/afrik-hub/" class="text-gray-400 hover:text-indigo-400 transition text-lg" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ route('newsletters.create') }}" class="text-gray-400 hover:text-indigo-400 transition text-lg" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            {{-- Colonne 2 : Navigation --}}
            <div>
                <h4 class="text-sm md:text-base font-semibold mb-4 text-indigo-300 uppercase tracking-wider">Navigation</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('accueil') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Accueil</a></li>
                    <li><a href="{{ route('recherche') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Rechercher</a></li>
                    <li><a href="{{ route('clients_historique') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Mes Réservations</a></li>
                </ul>
            </div>

            {{-- Colonne 3 : Support & Aide --}}
            <div>
                <h4 class="text-sm md:text-base font-semibold mb-4 text-indigo-300 uppercase tracking-wider">Aide</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('faq') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">FAQ</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Support Technique</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Déposer une annonce</a></li>
                </ul>
            </div>

            {{-- Colonne 4 : Légal --}}
            <div>
                <h4 class="text-sm md:text-base font-semibold mb-4 text-indigo-300 uppercase tracking-wider">Légal</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('mentions_legales')}}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Mentions Légales</a></li>
                    <li><a href="{{ route('politique_confidentialite') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Confidentialité</a></li>
                    <li><a href="{{ route('conditions_generales') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition block">Conditions Générales</a></li>
                </ul>
            </div>
        </div>

        {{-- Bas de page : Centré sur mobile, espacé sur desktop --}}
        <div class="flex flex-col md:flex-row justify-between items-center text-gray-500 pt-8">
            <p class="text-[10px] md:text-xs order-2 md:order-1 mt-6 md:mt-0 uppercase tracking-widest text-center">
                &copy; {{ date('Y') }} Afrik'Hub. Tous droits réservés.
            </p>
            <p class="text-xs order-1 md:order-2 flex items-center justify-center">
                <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i> Basé en Afrique de l'Ouest
            </p>
        </div>
    </div>
</footer>