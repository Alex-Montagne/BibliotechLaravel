<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinyle extends Model
{
    use HasFactory;

    protected $table = 'vinyles';

    protected $fillable = [
        'titre',
        'auteur',
        'annee',
        'nb_tours',
        'num_serie',
        'disponible',
        'categorie_id'
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'annee' => 'integer',
        'nb_tours' => 'integer'
    ];

    /**
     * Scope pour les vinyles disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }

    /**
     * Scope pour rechercher par titre ou auteur
     */
    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'like', '%' . $terme . '%')
            ->orWhere('auteur', 'like', '%' . $terme . '%');
    }

    /**
     * Un livre appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeParCategorie($query, $categorieNom)
    {
        return $query->where('categorie', $categorieNom);
    }

    /**
     * Scope pour filtrer par catégorie via relation
     */
    public function scopeParCategorieSlug($query, $categorieSlug)
    {
        return $query->whereHas('categorie', function ($q) use ($categorieSlug) {
            $q->where('slug', $categorieSlug);
        });
    }

    /**
     * Accesseur pour l'URL du vinyle
     */
    public function getUrlAttribute()
    {
        return route('vinyle.show', $this->id);
    }
}
