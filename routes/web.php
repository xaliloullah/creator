<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DeviController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\VCardController;

use App\Http\Controllers\RH\PosteController;
use App\Http\Controllers\RH\EmployeController;
use App\Http\Controllers\RH\PointageController;

use Illuminate\Support\Facades\Route;

Route::controller(RouteController::class)->group(function () {
    Route::get('/', 'accueil')->name('accueil');
    // Route::get('/admin-creator', 'admin')->name('admin')->middleware(['auth', 'verified', 'role:admin', 'password.confirm']);
});




Route::get('vcard/download-{id}', [VCardController::class, 'download'])->name('vcard.download');
Route::get('vcard-{id}', [VCardController::class, 'show'])->name('vcard');
Route::get('resume-{id}', [ResumeController::class, 'show'])->name('resume');
Route::get('devis-{id}', [DeviController::class, 'show'])->name('devis');
Route::get('factures-{id}', [FactureController::class, 'show'])->name('factures');
Route::get('services-{id}', [ServiceController::class, 'show'])->name('services');



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('paiements', PaiementController::class);
    Route::controller(PaiementController::class)->group(function () {
        Route::get('paiement/tarif/{id}', 'mode_paiement')->name('paiement.mode');
        Route::post('paiement', 'paiement')->name('paiement');
    });
});



// auth
Route::middleware(['auth', 'verified', 'role:admin|user'])->prefix('dashboard')->group(function () {
    Route::get('/', [RouteController::class, 'dashboard'])->name('dashboard');
    // profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/paramètres', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/profil/paramètres', [ProfileController::class, 'settings'])->name('profile.settings');

    // abonnements
    Route::resource('abonnements', AbonnementController::class);
    Route::controller(AbonnementController::class)->group(function () {
        Route::get('abonnements-statut', 'statut')->name('abonnements.statut');
    });

    // clients
    Route::resource('clients', ClientController::class)->middleware('permission:clients');
    Route::post('clients/search', [ClientController::class, 'search'])->name('clients.search');

    // notifications
    Route::resource('notifications', NotificationController::class);
    // factures
    Route::resource('factures', FactureController::class)->middleware('permission:factures');
    // devis
    Route::resource('devis', DeviController::class)->middleware('permission:devis');
    // contrats
    Route::resource('contrats', ContratController::class)->middleware('permission:contrats');
    // vcards
    Route::resource('vcards', VCardController::class)->middleware('permission:vcards');
    // resumes
    Route::resource('resumes', ResumeController::class)->middleware('permission:resumes');
    // qrcodes
    Route::resource('qrcodes', QrCodeController::class)->middleware('permission:qrcodes');
    // services
    Route::resource('services', ServiceController::class)->middleware('permission:services');

    // articles 
    Route::resource('categories', CategorieController::class)->middleware('permission:categories');
    Route::resource('produits', ProduitController::class)->middleware('permission:produits');

    // rh
    Route::resource('postes', PosteController::class)->middleware('permission:postes');
    Route::resource('employes', EmployeController::class)->middleware('permission:employes');
    Route::resource('pointages', PointageController::class)->middleware('permission:pointages');

    Route::resource('journals', JournalController::class)->middleware('permission:journal');
    
    // emails
    Route::resource('emails', EmailController::class)->middleware('permission:emails');
    // Route::controller(EmailController::class)->group(function () {
    //     Route::get('emails-statut', 'statut')->name('emails.statut');
    //     Route::get('emails-download-{id}', 'download')->name('emails.download');
    // });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/chat.php';
