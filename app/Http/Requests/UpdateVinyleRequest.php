<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVinyleRequest extends FormRequest
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
            'titre' => 'required|string|max:255|unique:vinyles,titre,' . $this->vinyle->id,
            'auteur' => 'nullable|string|max:255',
            'annee' => 'nullable|integer|min:1000|max:' . date('Y'),
            'nb_tours' => 'nullable|integer|min:1',
            'num_serie' => 'nullable|string|max:20|unique:vinyles,num_serie,' . $this->vinyle->id,
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
            'nb_tours.integer' => 'Le nombre de tours doit être un nombre.',
            'nb_tours.min' => 'Le vinyle doit avoir au moins 1 tour.',
            'num_serie.unique' => 'Ce numéro de série existe déjà.',
        ];
    }
}
