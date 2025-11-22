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
use App\Http\Controllers\DevenirProController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SejourController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// --------------------------------------------------
// ROUTES PUBLIQUES
// --------------------------------------------------
Route::get('/', [ResidenceController::class, 'accueil'])->name('accueil');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/message', fn() => view('pages.messages'))->name('message');

// Actions publiques
Route::get('/email_repeat', [LogController::class, 'email_repeat'])->name('email_repeat');
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/logout', [LogController::class, 'logout'])->name('logout');
Route::post('/login-auth', [LoginController::class, 'login'])->name('login.post');

// mots de passe oublié
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// --------------------------------------------------
// ROUTES AUTHENTIFIÉES
// --------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Pages résidences
    Route::get('/mise_en_ligne', fn() => view('pages.mise_en_ligne'))->name('mise_en_ligne');
    Route::get('/details/{id}', [ResidenceController::class, 'details'])->name('details');

    // Recherche
    Route::get('/recherche', [ResidenceController::class, 'recherche_img'])->name('recherche');

    // Réservations
    Route::post('/reservation/{id}', [ReservationController::class, 'store'])->name('reservation.store');
    Route::post('/reservation/{id}/annulation', [ReservationController::class, 'annuler'])->name('reservation.annuler');
    Route::get('/reservation/{id}/rebook', [ReservationController::class, 'rebook'])->name('reservation.rebook');
    Route::get('/mes-demandes', [ReservationController::class, 'mesDemandes'])->name('mes_demandes');

    // Mode client
    Route::get('/client/reservations', [ClientController::class, 'historiqueReservations'])->name('clients_historique');
    Route::get('/client/factures', [ClientController::class, 'historiqueFactures'])->name('factures');
    Route::get('/facture/{reservationId}/telecharger', [ClientController::class, 'telechargerFacture'])->name('facture.telecharger');

    // Devenir Pro
    Route::get('/devenir-pro', [DevenirProController::class, 'devenirPro'])->name('devenir_pro');
    Route::post('/devenir-pro', [DevenirProController::class, 'validerDevenirPro'])->name('valider_devenir_pro');

    // Professionnel (Pro)
    Route::middleware([ProMiddleware::class])->group(function () {
        Route::get('/pro/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('pro.dashboard');
        Route::get('/dashboard_resi_reserv', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard_resi_reserv');
        Route::get('/reservationRecu', [ResidenceController::class, 'reservationRecu'])->name('reservationRecu');
        Route::post('/reservation/{id}/accepter', [ReservationController::class, 'accepter'])->name('reservation.accepter');
        Route::post('/reservation/{id}/refuser', [ReservationController::class, 'refuser'])->name('reservation.refuser');
        Route::get('/occupees', [ResidenceController::class, 'occupees'])->name('occupees');

        // Gestion des résidences pro
        Route::get('/mes-residences', [ResidenceController::class, 'index'])->name('pro.residences');
        Route::post('/residences', [ResidenceController::class, 'store'])->name('residences.store');
    });

    // File Manager
    Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
    Route::post('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file.manager.delete');

    // Interruption séjour
    Route::get('/interrompre/{id}', [SejourController::class, 'interrompreForm'])->name('sejour.interrompre');
    Route::post('/interrompre/{id}', [SejourController::class, 'demanderInterruption'])->name('sejour.demander');
});

// Paiement
Route::get('/payer/{reservation}', [PaiementController::class, 'index'])->name('payer');
Route::match(['get', 'post'], '/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');
Route::post('/paiement/webhook', [PaiementController::class, 'webhook'])
    ->name('paiement.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

// Mise à jour automatique
Route::get('/auto/terminer', [Mise_a_jour::class, 'terminerReservationsDuJour']);

// --------------------------------------------------
// ROUTES ADMIN
// --------------------------------------------------

// Login Admin (PUBLIC)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

// Dashboard et gestion admin (PROTÉGÉ)
Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin_residences', [AdminController::class, 'residences'])->name('admin.residences');

    // Gestion des Residences
    Route::delete('/residences/{residence}/sup', [AdminController::class, 'suppression'])->name('admin.residences.sup');
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

    // Gestion interruptions
    Route::get('/interruptions', [SejourController::class, 'adminDemandes'])->name('admin.demande.interruptions');
    Route::post('/interruptions/{id}/valider', [SejourController::class, 'validerDemande'])->name('admin.demande.valider');
    Route::post('/interruptions/{id}/rejeter', [SejourController::class, 'rejeterDemande'])->name('admin.demande.rejeter');
});





