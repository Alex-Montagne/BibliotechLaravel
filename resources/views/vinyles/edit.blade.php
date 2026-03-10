@extends('layouts.app', [
    'title' => 'Modifier le vinyle: ' . $vinyle->titre,
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => route('vinyles.index')],
        ['label' => $vinyle->titre, 'url' => route('vinyles.show', $vinyle->id)],
        ['label' => 'Modifier', 'url' => null]
    ]
])

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h2 class="mb-0"><i class="fas fa-edit"></i> Modifier le vinyle</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('vinyles.update', $vinyle->id) }}" method="POST" class="needs-validation">
                        @csrf
                        @method('PUT')

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label for="titre" class="form-label"><strong>Titre</strong> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre', $vinyle->titre) }}" 
                                   placeholder="Entrez le titre du vinyle" required>
                            @error('titre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Auteur --}}
                        <div class="mb-3">
                            <label for="auteur" class="form-label">Auteur</label>
                            <input type="text" class="form-control @error('auteur') is-invalid @enderror" 
                                   id="auteur" name="auteur" value="{{ old('auteur', $vinyle->auteur) }}" 
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
                                        @if(old('categorie_id', $vinyle->categorie_id) == $categorie->id) selected @endif>
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
                                       id="annee" name="annee" value="{{ old('annee', $vinyle->annee) }}" 
                                       placeholder="Exemple: 2024" min="1000" max="{{ date('Y') }}">
                                @error('annee')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nombre de tours --}}
                            <div class="col-md-6 mb-3">
                                <label for="nb_tours" class="form-label">Nombre de tours</label>
                                <input type="number" class="form-control @error('nb_tours') is-invalid @enderror" 
                                       id="nb_tours" name="nb_tours" value="{{ old('nb_tours', $vinyle->nb_tours) }}" 
                                       placeholder="Exemple: 33" min="1">
                                @error('nb_tours')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Numéro de série --}}
                        <div class="mb-3">
                            <label for="num_serie" class="form-label">Numéro de série</label>
                            <input type="text" class="form-control @error('num_serie') is-invalid @enderror" 
                                   id="num_serie" name="num_serie" value="{{ old('num_serie', $vinyle->num_serie) }}" 
                                   placeholder="Exemple: ABC-123">
                            @error('num_serie')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Disponible --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1" {{ old('disponible', $vinyle->disponible) ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponible">
                                    Disponible à l'emprunt
                                </label>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('vinyles.show', $vinyle->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection