<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255|unique:livres',
            'auteur' => 'nullable|string|max:255',
            'annee' => 'nullable|integer|min:1000|max:' . date('Y'),
            'nb_pages' => 'nullable|integer|min:1',
            'isbn' => 'nullable|string|max:20|unique:livres',
            'resume' => 'nullable|string|max:1000',
            'couverture' => 'nullable|string|max:255',
            'disponible' => 'boolean',
            'categorie_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.unique' => 'Ce titre existe déjà dans la base de données.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'categorie_id.required' => 'Vous devez sélectionner une catégorie.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'annee.integer' => 'L\'année doit être un nombre.',
            'annee.min' => 'L\'année doit être au minimum 1000.',
            'nb_pages.integer' => 'Le nombre de pages doit être un nombre.',
            'nb_pages.min' => 'Le livre doit avoir au moins 1 page.',
            'isbn.unique' => 'Cet ISBN existe déjà.',
        ];
    }
}
