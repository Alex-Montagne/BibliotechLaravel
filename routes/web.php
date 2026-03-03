<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\LivreController;

/*
|--------------------------------------------------------------------------
| SÉANCE 1 : Routes Fondamentales
|--------------------------------------------------------------------------
| Focus : Comprendre le routage Laravel basique
| - Routes simples
| - Paramètres d'URL
| - Routes nommées
| - Contrôleurs
*/

Route::get('/test-debug', function () { 
    return 'Laravel fonctionne !'; 
});

// 1. Accueil - Route simple
Route::get('/', [AccueilController::class, 'index'])->name('home');

// 2. À propos - Route vers vue directe  
Route::get('/about', function () {
    return view('about');
})->name('about');

// 3-6. Routes CRUD Resource pour les livres (Séance 3)
// GET /livres (index) - Liste
// GET /livres/create - Formulaire création
// POST /livres (store) - Sauvegarde création
// GET /livres/{livre} (show) - Détail
// GET /livres/{livre}/edit - Formulaire édition
// PUT /livres/{livre} (update) - Sauvegarde édition
// DELETE /livres/{livre} (destroy) - Suppression
Route::resource('livres', LivreController::class);

// Route supplémentaire pour la recherche (Séance 2)
Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

// Route de démonstration pour comprendre les paramètres
Route::get('/demo/hello/{nom?}', function ($nom = 'Étudiant') {
    return view('demo.hello', ['nom' => $nom]);
})->name('demo.hello');

// Route de test pour déboguer - retourne du HTML simple
Route::get('/test', function () {
    return '<h1>Test Laravel fonctionne !</h1><p>Si vous voyez ce message, Laravel fonctionne.</p>';
})->name('test');

/*
|--------------------------------------------------------------------------
| SÉANCE 4 : Routes Authentification
|--------------------------------------------------------------------------
| Focus : Authentification, sessions et sécurité
| - Inscription et connexion
| - Gestion des sessions
| - Rôles et permissions
*/

use App\Http\Controllers\Auth\AuthController;

// Routes d'authentification (publiques)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout (authentifié)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
