<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('pages.heritage_pages', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $totalResidences = Residence::where('proprietaire_id', $userId)->count();
                $totalResidencesOccupees = Residence::where('proprietaire_id', $userId)->where('disponible', 0)->count();
                $totalReservationsRecu = Reservation::where('proprietaire_id', $userId)->where('status', 'confirmée')->count();
                $totalDemandesEnAttente = Reservation::where('proprietaire_id', $userId)->where('status', 'en attente')->count();

                $view->with(compact('totalResidences', 'totalResidencesOccupees', 'totalReservationsReçu', 'totalDemandesEnAttente'));
            }
        });
    }
}
