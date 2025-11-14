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
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// NOTE TRÈS IMPORTANTE : J'AI RETIRÉ L'IMPORTATION QUI CAUSAIT L'ERREUR DE FICHIER NON TROUVÉ.
// use App\Http\Middleware\VerifyCsrfToken;


// --------------------------------------------------
// ROUTES PUBLIQUES (pages principales)
// --------------------------------------------------

Route::get('/', [ResidenceController::class, 'accueil'])->name('accueil');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/recherche', function () {
    return view('pages.recherche');
})->name('recherche');

Route::get('/message', function () {
    return view('pages.messages');
})->name('message');

Route::get('/residences', function () {
    return view('pages.residences');
})->name('residences');

Route::get('/mise_en_ligne', function () {
    return view('pages.mise_en_ligne');
})->name('mise_en_ligne');

Route::get('/accueil', function () {
    return view('accueil');
})->middleware('auth')->name('accueil');


// --------------------------------------------------
// ROUTES D’ACTIONS (vérifications, redirections…)
// --------------------------------------------------

Route::get('/email_repeat', [LogController::class, 'email_repeat'])->name('email_repeat');
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/logout', [LogController::class, 'logout'])->name('logout');


// --------------------------------------------------
// ROUTES DE RÉSIDENCE (affichage, recherche, détails…)
// --------------------------------------------------

Route::get('/recherche', [ResidenceController::class, 'recherche_img'])->name('recherche')->middleware('auth');
Route::get('/details/{id}', [ResidenceController::class, 'details'])->name('details');
Route::get('/residences', [ResidenceController::class, 'index'])->name('residences')->middleware('auth');
Route::get('/dashboard_resi_reserv', [ResidenceController::class, 'dashboard_resi_reserv'])->name('dashboard_resi_reserv')->middleware('auth');
Route::get('/occupees', [ResidenceController::class, 'occupees'])->name('occupees')->middleware('auth');
Route::get('/dashboard', [ResidenceController::class, 'dashboard_resi_reserv'])->middleware('auth')->name('dashboard');

// Action : enregistrement d’une résidence
Route::post('/residences', [ResidenceController::class, 'store'])->name('residences.store');


// --------------------------------------------------
// ROUTES DE RÉSERVATION
// --------------------------------------------------

Route::post('/reservation/{id}', [ReservationController::class, 'store'])->middleware('auth')->name('reservation.store');
Route::post('/reservation/{id}/anulation', [ReservationController::class, 'annuler'])->name('annuler');
Route::post('/reservation/{id}/accepter', [ReservationController::class, 'accepter'])->name('reservation.accepter');
Route::post('/reservation/{id}/refuser', [ReservationController::class, 'refuser'])->name('reservation.refuser');
Route::get('/reservation/{id}/rebook', [ReservationController::class, 'rebook'])->name('rebook');

Route::get('/historique', [ReservationController::class, 'historique'])->middleware('auth')->name('historique');
Route::get('/mes-demandes', [ReservationController::class, 'mesDemandes'])->middleware('auth')->name('mes_demandes');


// --------------------------------------------------
// ROUTES ADMIN
// --------------------------------------------------

// Dashboard admin
Route::get('/admin_dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');

// Gestion des résidences (Admin)
Route::get('/admin/residences', [AdminController::class, 'residences'])->name('admin.residences');
Route::get('residences/{residence}/edit', [AdminController::class, 'modification'])->name('admin.residences.edit');
Route::post('residences/{id}/activation', [AdminController::class, 'activation'])->name('admin.residences.activation');
Route::post('residences/{id}/desactivation', [AdminController::class, 'desactivation'])->name('admin.residences.desactivation');
Route::put('/residences/{residence}/update', [AdminController::class, 'update'])->name('admin.residences.update');
Route::delete('residences/{residence}/sup', [AdminController::class, 'suppression'])->name('admin.residences.sup');
Route::post('/admin/residences/liberer/{id}', [AdminController::class, 'libererResidence'])->name('admin.libererResidence');

// Gestion des réservations (Admin)
Route::get('reservations', [AdminController::class, 'reservations'])->name('admin.reservations.all');
Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');

// Gestion des utilisateurs (Admin)
Route::get('utilisateur', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs.all');
Route::get('/admin/users/{user}/residences', [AdminController::class, 'showUserResidences'])->name('admin.users.residences');
Route::post('/admin/users/{user}/toggle', [AdminController::class, 'toggleUserSuspension'])->name('admin.users.toggle_suspension');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');


// --------------------------------------------------
// FILE MANAGER
// --------------------------------------------------

Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
Route::post('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file.manager.delete');


// --------------------------------------------------
// PAIEMENT
// --------------------------------------------------

Route::get('/payer/{reservation}', [PaiementController::class, 'index'])->name('payer');
Route::match(['get', 'post'], '/paiement/callback', [PaiementController::class, 'callback'])->name('paiement.callback');
Route::post('/paiement/webhook', [PaiementController::class, 'webhook'])
    ->name('paiement.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);


// --------------------------------------------------
// LOGIN
// --------------------------------------------------

Route::post('/login-auth', [LoginController::class, 'login'])->name('login.post');


// --------------------------------------------------
// CLIENTS AUTHENTIFIÉS
// --------------------------------------------------

Route::middleware(['auth'])->group(function () {
    // Historique des réservations (toutes)
    Route::get('/client/reservations', [ClientController::class, 'historiqueReservations'])->name('clients_historique');

    // Historique des factures
    Route::get('/client/factures', [ClientController::class, 'historiqueFactures'])->name('factures');

    // Téléchargement de facture
    Route::middleware('auth')->group(function () {
        Route::get('/facture/{reservationId}/telecharger', [ClientController::class, 'telechargerFacture'])
            ->name('facture.telecharger');
    });
});
