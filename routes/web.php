<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Mise_a_jour;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProMiddleware;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

// --------------------------------------------------
// ROUTES PUBLIQUES
// --------------------------------------------------
Route::get('/admin_login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::get('/', [ResidenceController::class, 'accueil'])->name('accueil');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/message', fn() => view('pages.messages'))->name('message');

// Actions publiques
Route::get('/email_repeat', [LogController::class, 'email_repeat'])->name('email_repeat');
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/logout', [LogController::class, 'logout'])->name('logout');
Route::post('/login-auth', [LoginController::class, 'login'])->name('login.post');

// --------------------------------------------------
// ROUTES AUTHENTIFIÉES
// --------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Pages résidences
    Route::get('/residences', fn() => view('pages.residences'))->name('residences');
    Route::get('/mise_en_ligne', fn() => view('pages.mise_en_ligne'))->name('mise_en_ligne');
    Route::get('/details/{id}', [ResidenceController::class, 'details'])->name('details');

    //recherche
    Route::get('/recherche', fn() => view('pages.recherche'))->name('recherche');// page de recherche
    Route::get('/recherche', [ResidenceController::class, 'recherche_img'])->name('recherche'); // fonction de recherche

    // Réservations
    Route::post('/reservation/{id}', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/reservation/{id}/annulation', [ReservationController::class, 'annuler'])->name('reservation.annuler');
    Route::get('/reservation/{id}/rebook', [ReservationController::class, 'rebook'])->name('reservation.rebook');
    Route::get('/mes-demandes', [ReservationController::class, 'mesDemandes'])->name('mes_demandes');

    // Client
    Route::middleware([ClientMiddleware::class])->group(function () {
        Route::get('/client/reservations', [ClientController::class, 'historiqueReservations'])->name('clients_historique');
        Route::get('/client/factures', [ClientController::class, 'historiqueFactures'])->name('factures');
        Route::get('/facture/{reservationId}/telecharger', [ClientController::class, 'telechargerFacture'])->name('facture.telecharger');
    });

    // Professionnel (Pro)
    Route::middleware([ProMiddleware::class])->group(function () {
        Route::get('/pro/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('pro.dashboard');
        Route::get('/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard');
        Route::get('/dashboard_resi_reserv', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard_resi_reserv');
        Route::get('/reservationRecu', [ResidenceController::class, 'reservationRecu'])->name('reservationRecu');
        Route::post('/reservation/{id}/accepter', [ReservationController::class, 'accepter'])->name('reservation.accepter');
        Route::post('/reservation/{id}/refuser', [ReservationController::class, 'refuser'])->name('reservation.refuser');
        Route::get('/occupees', [ResidenceController::class, 'occupees'])->name('occupees');

        // Gestion des résidences pro
        Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
        Route::post('/residences', [ResidenceController::class, 'store'])->name('residences.store');
    });

    // Admin
    Route::prefix('admin')->group(function () {
        // Login Admin
        Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        // Dashboard et gestion admin
        Route::middleware([AdminMiddleware::class])->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::get('/residences', [AdminController::class, 'residences'])->name('admin.residences');
            // Gestion des Residences
            Route::delete('residences/{residence}/sup', [AdminController::class, 'suppression'])->name('admin.residences.sup');
            Route::get('/residences/{residence}/edit', [AdminController::class, 'modification'])->name('admin.residences.edit');
            Route::put('/residences/{residence}/update', [AdminController::class, 'update'])->name('admin.residences.update');
            Route::post('/residences/{id}/activation', [AdminController::class, 'activation'])->name('admin.residences.activation');
            Route::post('/residences/{id}/desactivation', [AdminController::class, 'desactivation'])->name('admin.residences.desactivation');
            Route::post('/residences/liberer/{id}', [AdminController::class, 'libererResidence'])->name('admin.libererResidence');

            // Gestion des réservations
            Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
            // Gestion des utilisateurs
            Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs.all');
            Route::get('/users/{user}/residences', [AdminController::class, 'showUserResidences'])->name('admin.users.residences');
            Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUserSuspension'])->name('admin.users.toggle_suspension');
            Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        });
    });

    // File Manager
    Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
    Route::post('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file.manager.delete');
});

// Paiement
Route::get('/payer/{reservation}', [PaiementController::class, 'index'])->name('payer');
Route::match(['get', 'post'], '/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');
Route::post('/paiement/webhook', [PaiementController::class, 'webhook'])
    ->name('paiement.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

// Mise à jour automatique des statuts / disponibilités
Route::get('/auto/terminer', [Mise_a_jour::class, 'terminerReservationsDuJour']);
