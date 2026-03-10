<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vinyle;
use App\Models\Categorie;
use App\Http\Requests\StoreVinyleRequest;
use App\Http\Requests\UpdateVinyleRequest;

class VinyleController extends Controller
{
    /**
     * Affichage liste avec base de données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour récupérer les données depuis SQLite
     */
    public function index()
    {
        // Récupération des vinyles avec leurs catégories via Eloquent
        $vinyles = Vinyle::with('categorie')->get();

        // Récupération des catégories pour le filtre
        $categories = Categorie::actives()->get();

        $statistiques = [
            'totalVinyles' => Vinyle::count(),
            'vinylesDisponibles' => Vinyle::disponible()->count(),
            'totalCategories' => Categorie::actives()->count()
        ];

        return view('vinyles.index', [
            'vinyles' => $vinyles,
            'categories' => $categories,
            'stats' => $statistiques,
            'total' => $vinyles->count()
        ]);
    }

    /**
     * Affichage formulaire création
     * SÉANCE 3 : Afficher le formulaire pour créer un vinyle
     */
    public function create()
    {
        $categories = Categorie::actives()->get();

        return view('vinyles.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Sauvegarde d'un vinyle créé
     * SÉANCE 3 : Stocker les données validées et rediriger
     */
    public function store(StoreVinyleRequest $request)
    {
        // Utilisation de la Form Request Validation pour la validation
        $vinyle = Vinyle::create($request->validated());

        return redirect()->route('vinyles.show', $vinyle->id)
            ->with('success', "Le vinyle '{$vinyle->titre}' a été créé avec succès!");
    }

    /**
     * Affichage détail avec paramètre d'URL et Eloquent
     * SÉANCE 2 : Utiliser Eloquent pour récupérer un enregistrement spécifique
     */
    public function show(Vinyle $vinyle)
    {
        $vinyle->load('categorie');

        return view('vinyles.show', [
            'vinyle' => $vinyle
        ]);
    }

    /**
     * Affichage formulaire édition
     * SÉANCE 3 : Route Model Binding - Récupérer le vinyle et afficher le formulaire
     */
    public function edit(Vinyle $vinyle)
    {
        $categories = Categorie::actives()->get();

        return view('vinyles.edit', [
            'vinyle' => $vinyle,
            'categories' => $categories
        ]);
    }

    /**
     * Mise à jour d'un vinyle
     * SÉANCE 3 : Valider et mettre à jour les données
     */
    public function update(UpdateVinyleRequest $request, Vinyle $vinyle)
    {
        $vinyle->update($request->validated());

        return redirect()->route('vinyles.show', $vinyle->id)
            ->with('success', "Le vinyle '{$vinyle->titre}' a été modifié avec succès!");
    }

    /**
     * Suppression d'un vinyle
     * SÉANCE 3 : Supprimer le vinyle et rediriger
     */
    public function destroy(Vinyle $vinyle)
    {
        $titre = $vinyle->titre;
        $vinyle->delete();

        return redirect()->route('vinyles.index')
            ->with('success', "Le vinyle '{$titre}' a été supprimé avec succès!");
    }

    /**
     * Recherche de vinyles avec Eloquent
     * SÉANCE 2 : Utiliser les scopes Eloquent pour la recherche
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Utilisation des scopes Eloquent pour la recherche
        $vinyles = Vinyle::with('categorie')
            ->when($query, function ($queryBuilder, $searchTerm) {
                return $queryBuilder->recherche($searchTerm);
            })
            ->get();

        return view('vinyles.search', [
            'vinyles' => $vinyles,
            'query' => $query,
            'total' => $vinyles->count()
        ]);
    }
}
