<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProMiddleware;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

// --------------------------------------------------
// ROUTES PUBLIQUES (accessible sans login)
// --------------------------------------------------
Route::get('/', [ResidenceController::class, 'accueil'])->name('accueil');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/recherche', fn() => view('pages.recherche'))->name('recherche');
Route::get('/message', fn() => view('pages.messages'))->name('message');
Route::get('/residences', fn() => view('pages.residences'))->name('residences');
Route::get('/mise_en_ligne', fn() => view('pages.mise_en_ligne'))->name('mise_en_ligne');

// --------------------------------------------------
// ROUTES D’ACTIONS
// --------------------------------------------------
Route::get('/email_repeat', [LogController::class, 'email_repeat'])->name('email_repeat');
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/logout', [LogController::class, 'logout'])->name('logout');
Route::post('/login-auth', [LoginController::class, 'login'])->name('login.post');

// --------------------------------------------------
// ROUTES AUTHENTIFIÉES (général pour tous types d'utilisateurs)
// --------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Pages résidences
    Route::get('/recherche', [ResidenceController::class, 'recherche_img'])->name('recherche');
    Route::get('/details/{id}', [ResidenceController::class, 'details'])->name('details');

    // Réservations
    Route::post('/reservation/{id}', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/reservation/{id}/anulation', [ReservationController::class, 'annuler'])->name('annuler');
    Route::get('/reservation/{id}/rebook', [ReservationController::class, 'rebook'])->name('rebook');


    Route::get('/mes-demandes', [ReservationController::class, 'mesDemandes'])->name('mes_demandes');

    // CLIENTS
    Route::middleware([ClientMiddleware::class])->group(function () {
        Route::get('/client/reservations', [ClientController::class, 'historiqueReservations'])->name('clients_historique');
        Route::get('/client/factures', [ClientController::class, 'historiqueFactures'])->name('factures');
        Route::get('/facture/{reservationId}/telecharger', [ClientController::class, 'telechargerFacture'])->name('facture.telecharger');
    });

    // PRO
    Route::middleware([ProMiddleware::class])->group(function () {
        // Ici tu peux ajouter toutes les routes réservées aux professionnels


        Route::get('/dashboard_resi_reserv', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard_resi_reserv');
        Route::post('/reservation/{id}/accepter', [ReservationController::class, 'accepter'])->name('reservation.accepter');
        Route::post('/reservation/{id}/refuser', [ReservationController::class, 'refuser'])->name('reservation.refuser');
        Route::get('/pro/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('pro.dashboard');
        Route::get('/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard');
        Route::get('/historique', [ResidenceController::class, 'historique'])->name('historique');
        Route::post('/residences', [ResidenceController::class, 'store'])->name('residences.store');
        Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
        Route::get('/occupees', [ResidenceController::class, 'occupees'])->name('occupees');

    });

    // ADMIN
    Route::middleware([AdminMiddleware::class])->group(function () {

        // Dashboard admin
        Route::get('/admin_dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');

        // Gestion des résidences
        Route::get('/admin/residences', [AdminController::class, 'residences'])->name('admin.residences');
        Route::get('residences/{residence}/edit', [AdminController::class, 'modification'])->name('admin.residences.edit');
        Route::post('residences/{id}/activation', [AdminController::class, 'activation'])->name('admin.residences.activation');
        Route::post('residences/{id}/desactivation', [AdminController::class, 'desactivation'])->name('admin.residences.desactivation');
        Route::put('/residences/{residence}/update', [AdminController::class, 'update'])->name('admin.residences.update');
        Route::delete('residences/{residence}/sup', [AdminController::class, 'suppression'])->name('admin.residences.sup');
        Route::post('/admin/residences/liberer/{id}', [AdminController::class, 'libererResidence'])->name('admin.libererResidence');

        // Gestion des réservations
        Route::get('reservations', [AdminController::class, 'reservations'])->name('admin.reservations.all');
        Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');

        // Gestion des utilisateurs
        Route::get('utilisateur', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs.all');
        Route::get('/admin/users/{user}/residences', [AdminController::class, 'showUserResidences'])->name('admin.users.residences');
        Route::post('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserSuspension'])->name('admin.users.toggle_suspension');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });
});

// --------------------------------------------------
// FILE MANAGER (accessible à tous authentifiés)
// --------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
    Route::post('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file.manager.delete');
});

// --------------------------------------------------
// PAIEMENT
// --------------------------------------------------
Route::get('/payer/{reservation}', [PaiementController::class, 'index'])->name('payer');
Route::match(['get', 'post'], '/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');
Route::post('/paiement/webhook', [PaiementController::class, 'webhook'])
    ->name('paiement.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
