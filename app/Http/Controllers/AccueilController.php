<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use App\Models\Vinyle;
use Illuminate\Support\Facades\Auth;



class AccueilController extends Controller
{
    /**
     * Affichage de la page d'accueil avec données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour les statistiques d'accueil
     */
    public function index()
    {
        // Statistiques réelles depuis la base de données
        $stats = [
            'totalLivres' => Livre::count(),
            'livresDisponibles' => Livre::disponible()->count(),
            'totalVinyles' => Auth::check() && Auth::user()->isVinyleUser() ? Vinyle::count() : 0,
            'vinylesDisponibles' => Auth::check() && Auth::user()->isVinyleUser() ? Vinyle::disponible()->count() : 0,
            'totalEmprunts' => 12, // Sera implémenté dans une séance future
            'totalUtilisateurs' => 25, // Sera implémenté dans une séance future
            'totalCategories' => Categorie::actives()->count()
        ];

        // Livres mis en avant (3 premiers livres de la base)
        $livresEnVedette = Livre::with('categorie')
            ->disponible()
            ->take(3)
            ->get();

        // Vinyles mis en avant (3 premiers vinyles de la base) - seulement pour les utilisateurs vinyle
        $vinylesEnVedette = (Auth::check() && Auth::user()->isVinyleUser()) 
            ? Vinyle::with('categorie')
                ->disponible()
                ->take(3)
                ->get()
            : collect();

        return view('welcome', [
            'stats' => $stats,
            'livresEnVedette' => $livresEnVedette,
            'vinylesEnVedette' => $vinylesEnVedette
        ]);
    }
}
