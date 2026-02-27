<footer id="contact" class="border-t border-white/20 m-0 text-white" style="background: linear-gradient(135deg, #006d77, #00afb9);">
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 border-b border-white/10 pb-10 text-center md:text-left">
            
            {{-- Colonne 1 : Logo & Slogan --}}
            <div class="space-y-4">
                <h3 class="text-2xl font-black tracking-tight text-white">Afrik'Hub</h3>
                <p class="text-xs md:text-sm text-white/70 leading-relaxed max-w-xs mx-auto md:mx-0">
                    Votre Hub de Résidences en Afrique.
                </p>

                <div class="flex items-center justify-center md:justify-start text-white/80">
                    <i class="fa fa-phone text-xs me-3 text-white"></i>
                    <span class="text-xs md:text-sm font-medium">+225 01 03 09 06 16</span>
                </div>

                {{-- Réseaux Sociaux --}}
                <div class="flex justify-center md:justify-start space-x-4 pt-2">
                    <a href="https://www.facebook.com/share/1KgiASzTSe/" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white hover:text-[#006d77] transition-all text-sm" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@afrikhub5?_r=1&_t=ZM-92UhuMQAC3I" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white hover:text-[#006d77] transition-all text-sm" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/afrikhub2025?igsh=N25qeDltY2U3Mjdy" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white hover:text-[#006d77] transition-all text-sm" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/afrik-hub/" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white hover:text-[#006d77] transition-all text-sm" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ route('newsletters.create') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white hover:text-[#006d77] transition-all text-sm" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            {{-- Colonne 2 : Navigation --}}
            <div>
                <h4 class="text-sm font-bold mb-5 text-white uppercase tracking-widest">Navigation</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('accueil') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Accueil</a></li>
                    <li><a href="{{ route('recherche') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Rechercher</a></li>
                    <li><a href="{{ route('clients_historique') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Mes Réservations</a></li>
                </ul>
            </div>

            {{-- Colonne 3 : Support & Aide --}}
            <div>
                <h4 class="text-sm font-bold mb-5 text-white uppercase tracking-widest">Aide</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('faq') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">FAQ</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Support Technique</a></li>
                    <li><a href="https://wa.me/2250769480232" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Déposer une annonce</a></li>
                </ul>
            </div>

            {{-- Colonne 4 : Légal --}}
            <div>
                <h4 class="text-sm font-bold mb-5 text-white uppercase tracking-widest">Légal</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('mentions_legales')}}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Mentions Légales</a></li>
                    <li><a href="{{ route('politique_confidentialite') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Confidentialité</a></li>
                    <li><a href="{{ route('conditions_generales') }}" class="text-xs md:text-sm text-white/70 hover:text-white transition-colors block">Conditions Générales</a></li>
                </ul>
            </div>
        </div>

        {{-- Bas de page --}}
        <div class="flex flex-col md:flex-row justify-between items-center text-white/50 pt-8">
            <p class="text-[10px] md:text-xs order-2 md:order-1 mt-6 md:mt-0 uppercase tracking-[0.2em] font-medium text-center">
                &copy; {{ date('Y') }} Afrik'Hub. Tous droits réservés.
            </p>
            <p class="text-xs order-1 md:order-2 flex items-center justify-center font-medium text-white/80">
                <i class="fas fa-map-marker-alt mr-2 text-white"></i> Basé en Afrique de l'Ouest
            </p>
        </div>
    </div>
</footer>