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
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. ROUTES PUBLIQUES (ACCUEIL, AUTH, VUES)
// =========================================================================

// Route d'accueil principale
Route::get('/', [ResidenceController::class, 'accueil'])->name('accueil');

// Vues d'authentification et d'enregistrement
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');

// Traitement de l'authentification et de la déconnexion
Route::post('/login-auth', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LogController::class, 'logout'])->name('logout');

// Vues publiques diverses
Route::get('/mise_en_ligne', fn() => view('pages.mise_en_ligne'))->name('mise_en_ligne');
Route::get('/message', fn() => view('pages.messages'))->name('message');
Route::get('/recherche', fn() => view('pages.recherche'))->name('recherche'); // Vue de recherche générale

// Détails d'une résidence
Route::get('/details/{id}', [ResidenceController::class, 'details'])->name('details');

// Logique de vérification d'email
Route::get('/email_repeat', [LogController::class, 'email_repeat'])->name('email_repeat');
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');

// Webhook Paystack (sans middleware CSRF pour permettre la réception des notifications)
Route::post('/paiement/webhook', [PaiementController::class, 'webhook'])
    ->name('paiement.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);


// =========================================================================
// 2. ROUTES AUTHENTIFIÉES (UTILISATEUR CONNECTÉ)
// =========================================================================

Route::middleware('auth')->group(function () {

    // --- Dashboard & Résidences Utilisateur ---
    Route::get('/accueil', fn() => view('pages.dashboard'))->name('dashboard.user'); // Dashboard utilisateur
    Route::get('/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard'); // Logique Résidences/Réservations

    Route::get('/recherche', [ResidenceController::class, 'recherche_img'])->name('recherche.process'); // Recherche avec logique
    Route::get('/occupees', [ResidenceController::class, 'occupees'])->name('occupees');

    // CRUD Résidences
    Route::get('/residences', [ResidenceController::class, 'index'])->name('residences'); // Résidences de l'utilisateur
    Route::post('/residences', [ResidenceController::class, 'store'])->name('residences.store');

    // --- Réservations (Actions Utilisateur) ---
    Route::prefix('reservation')->group(function () {
        Route::post('/{id}', [ReservationController::class, 'store'])->name('reservation.store');
        Route::post('/{id}/anulation', [ReservationController::class, 'annuler'])->name('annuler');
        Route::get('/{id}/rebook', [ReservationController::class, 'rebook'])->name('rebook');
    });

    // --- Historiques & Demandes ---
    Route::get('/historique', [ReservationController::class, 'historique'])->name('historique'); // Historique de l'utilisateur
    Route::get('/mes-demandes', [ReservationController::class, 'mesDemandes'])->name('mes_demandes'); // Mes demandes de résa

    // --- Paiement ---
    Route::get('/payer/{reservation}', [PaiementController::class, 'index'])->name('payer');
    Route::match(['get', 'post'], '/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');

    // --- Gestion de Fichiers ---
    Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
    Route::post('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file.manager.delete');

    // --- Routes Client (Historique des factures/réservations) ---
    Route::prefix('client')->group(function () {
        Route::get('/reservations', [ClientController::class, 'historiqueReservations'])->name('clients_historique');
        Route::get('/factures', [ClientController::class, 'historiqueFactures'])->name('factures');
        Route::get('/facture/{reservationId}/telecharger', [ClientController::class, 'telechargerFacture'])
            ->name('facture.telecharger');
    });
});


//
// 3. ROUTES ADMINISTRATEUR (admin.*)
// 

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- Gestion des Résidences ---
    Route::prefix('residences')->name('residences.')->group(function () {
        Route::get('/', [AdminController::class, 'residences'])->name('all');
        Route::get('/{residence}/edit', [AdminController::class, 'modification'])->name('edit');
        Route::put('/{residence}/update', [AdminController::class, 'update'])->name('update');
        Route::post('/{id}/activation', [AdminController::class, 'activation'])->name('activation');
        Route::post('/{id}/desactivation', [AdminController::class, 'desactivation'])->name('desactivation');
        Route::delete('/{residence}/sup', [AdminController::class, 'suppression'])->name('sup');
        Route::post('/liberer/{id}', [AdminController::class, 'libererResidence'])->name('libererResidence');
    });

    // --- Gestion des Réservations ---
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminController::class, 'reservations'])->name('all');
        Route::post('/{id}/accepter', [ReservationController::class, 'accepter'])->name('accepter');
        Route::post('/{id}/refuser', [ReservationController::class, 'refuser'])->name('refuser');
    });

    // --- Gestion des Utilisateurs ---
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'utilisateurs'])->name('all');
        Route::get('/{user}/residences', [AdminController::class, 'showUserResidences'])->name('residences');
        Route::post('/{user}/toggle', [AdminController::class, 'toggleUserSuspension'])->name('toggle_suspension');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('destroy');
    });
});
