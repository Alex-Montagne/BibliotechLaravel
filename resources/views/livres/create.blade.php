@extends('layouts.app', [
    'title' => 'Créer un livre',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => route('livres.index')],
        ['label' => 'Créer un livre', 'url' => null]
    ]
])

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="fas fa-plus-circle"></i> Créer un nouveau livre</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.store') }}" method="POST" class="needs-validation">
                        @csrf

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label"><strong>Titre</strong> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre') }}" 
                                   placeholder="Entrez le titre du livre" required>
                            @error('titre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Auteur --}}
                        <div class="mb-3">
                            <label for="auteur" class="form-label">Auteur</label>
                            <input type="text" class="form-control @error('auteur') is-invalid @enderror" 
                                   id="auteur" name="auteur" value="{{ old('auteur') }}" 
                                   placeholder="Entrez le nom de l'auteur">
                            @error('auteur')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catégorie --}}
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label"><strong>Catégorie</strong> <span class="text-danger">*</span></label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    id="categorie_id" name="categorie_id" required>
                                <option value="">-- Sélectionnez une catégorie --</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                        @if(old('categorie_id') == $categorie->id) selected @endif>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Année --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="annee" class="form-label">Année de publication</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror" 
                                       id="annee" name="annee" value="{{ old('annee') }}" 
                                       placeholder="Exemple: 2024" min="1000" max="{{ date('Y') }}">
                                @error('annee')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nombre de pages --}}
                            <div class="col-md-6 mb-3">
                                <label for="nb_pages" class="form-label">Nombre de pages</label>
                                <input type="number" class="form-control @error('nb_pages') is-invalid @enderror" 
                                       id="nb_pages" name="nb_pages" value="{{ old('nb_pages') }}" 
                                       placeholder="Exemple: 350" min="1">
                                @error('nb_pages')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ISBN --}}
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" name="isbn" value="{{ old('isbn') }}" 
                                   placeholder="Exemple: 978-2-07-074155-2">
                            @error('isbn')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Résumé --}}
                        <div class="mb-3">
                            <label for="resume" class="form-label">Résumé</label>
                            <textarea class="form-control @error('resume') is-invalid @enderror" 
                                      id="resume" name="resume" rows="4" 
                                      placeholder="Entrez le résumé du livre...">{{ old('resume') }}</textarea>
                            @error('resume')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Disponibilité --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="disponible" 
                                       name="disponible" value="1" 
                                       @if(old('disponible', true)) checked @endif>
                                <label class="form-check-label" for="disponible">
                                    Le livre est disponible
                                </label>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le livre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
