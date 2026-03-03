<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Categorie;
use App\Http\Requests\StoreLivreRequest;
use App\Http\Requests\UpdateLivreRequest;

class LivreController extends Controller
{
    /**
     * Affichage liste avec base de données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour récupérer les données depuis SQLite
     */
    public function index()
    {
        // Récupération des livres avec leurs catégories via Eloquent
        $livres = Livre::with('categorie')->get();

        // Récupération des catégories pour le filtre
        $categories = Categorie::actives()->get();

        $statistiques = [
            'totalLivres' => Livre::count(),
            'livresDisponibles' => Livre::disponible()->count(),
            'totalCategories' => Categorie::actives()->count()
        ];

        return view('livres.index', [
            'livres' => $livres,
            'categories' => $categories,
            'stats' => $statistiques,
            'total' => $livres->count()
        ]);
    }

    /**
     * Affichage formulaire création
     * SÉANCE 3 : Afficher le formulaire pour créer un livre
     */
    public function create()
    {
        $categories = Categorie::actives()->get();
        
        return view('livres.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Sauvegarde d'un livre créé
     * SÉANCE 3 : Stocker les données validées et rediriger
     */
    public function store(StoreLivreRequest $request)
    {
        // Utilisation de la Form Request Validation pour la validation
        $livre = Livre::create($request->validated());

        return redirect()->route('livres.show', $livre->id)
            ->with('success', "Le livre '{$livre->titre}' a été créé avec succès!");
    }

    /**
     * Affichage détail avec paramètre d'URL et Eloquent
     * SÉANCE 2 : Utiliser Eloquent pour récupérer un enregistrement spécifique
     */
    public function show(Livre $livre)
    {
        $livre->load('categorie');
        
        return view('livres.show', [
            'livre' => $livre
        ]);
    }

    /**
     * Affichage formulaire édition
     * SÉANCE 3 : Route Model Binding - Récupérer le livre et afficher le formulaire
     */
    public function edit(Livre $livre)
    {
        $categories = Categorie::actives()->get();
        
        return view('livres.edit', [
            'livre' => $livre,
            'categories' => $categories
        ]);
    }

    /**
     * Mise à jour d'un livre
     * SÉANCE 3 : Valider et mettre à jour les données
     */
    public function update(UpdateLivreRequest $request, Livre $livre)
    {
        $livre->update($request->validated());

        return redirect()->route('livres.show', $livre->id)
            ->with('success', "Le livre '{$livre->titre}' a été modifié avec succès!");
    }

    /**
     * Suppression d'un livre
     * SÉANCE 3 : Supprimer le livre et rediriger
     */
    public function destroy(Livre $livre)
    {
        $titre = $livre->titre;
        $livre->delete();

        return redirect()->route('livres.index')
            ->with('success', "Le livre '{$titre}' a été supprimé avec succès!");
    }

    /**
     * Recherche de livres avec Eloquent
     * SÉANCE 2 : Utiliser les scopes Eloquent pour la recherche
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Utilisation des scopes Eloquent pour la recherche
        $livres = Livre::with('categorie')
            ->when($query, function ($queryBuilder, $searchTerm) {
                return $queryBuilder->recherche($searchTerm);
            })
            ->get();

        return view('livres.search', [
            'livres' => $livres,
            'query' => $query,
            'total' => $livres->count()
        ]);
    }
}
