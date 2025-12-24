<footer class="bg-gray-800 border-t border-indigo-700 mt-12 text-white">
    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-700 pb-6 mb-0">
            {{-- Colonne 1 : Logo / Slogan (Ajouté) --}}
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-xl font-bold text-indigo-400">Afrikhub</h3>
                <p class="text-sm text-gray-400 mt-2">Votre Hub de Résidences en Afrique.</p>

                {{-- Réseaux Sociaux (Ajouté) --}}
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.facebook.com/share/1KgiASzTSe/" class="text-gray-400 hover:text-indigo-400 transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-indigo-400 transition" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/afrikhub2025?igsh=N25qeDltY2U3Mjdy" class="text-gray-400 hover:text-indigo-400 transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/afrik-hub/" class="text-gray-400 hover:text-indigo-400 transition" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ route('newsletters.create') }}" class="text-gray-400 hover:text-indigo-400 transition" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            {{-- Colonne 2 : Liens Rapides (Exemple) --}}
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-3 text-indigo-300">Navigation</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('accueil') }}" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                    <li><a href="{{ route('recherche') }}" class="text-gray-400 hover:text-white transition">Rechercher</a></li>
                    <li><a href="{{ route('clients_historique') }}" class="text-gray-400 hover:text-white transition">Mes Réservations</a></li>
                </ul>
            </div>

            {{-- Colonne 3 : Support & Aide --}}
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-3 text-indigo-300">Aide</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-gray-400 hover:text-white transition">Support Technique</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-gray-400 hover:text-white transition">Déposer une annonce</a></li>
                </ul>
            </div>

            {{-- Colonne 4 : Légal --}}
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-3 text-indigo-300">Légal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('mentions_legales')}}" class="text-gray-400 hover:text-white transition">Mentions Légales</a></li>
                    <li><a href="{{ route('politique_confidentialite') }}" class="text-gray-400 hover:text-white transition">Politique de Confidentialité</a></li>
                    <li><a href="{{ route('conditions_generales') }}" class="text-gray-400 hover:text-white transition">Conditions Générales</a></li>
                </ul>
            </div>
        </div>

        {{-- Barre d'Information Basse --}}
        <div class="flex flex-col md:flex-row justify-between items-center text-gray-500 pt-2">
            <p class="text-sm order-2 md:order-1 mt-3 md:mt-0">
                &copy; {{ date('Y') }} Afrikhub. Tous droits réservés.
            </p>
            <p class="text-sm order-1 md:order-2">
                <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i> Basé en Afrique de l'Ouest
            </p>
        </div>
    </div>
</footer>
