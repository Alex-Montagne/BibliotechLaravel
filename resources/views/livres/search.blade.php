@extends('layouts.app', [
    'title' => 'Recherche de livres',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => route('livres.index')],
        ['label' => 'Recherche', 'url' => null]
    ]
])

@section('content')
<div class="container-fluid px-4 py-5">
    {{-- En-tête avec formulaire de recherche --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="mb-4"><i class="fas fa-search"></i> Recherche de Livres</h2>
                    <form action="{{ route('livres.search') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Rechercher par titre, auteur ou catégorie..."
                                   value="{{ $query }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                        @if($query)
                        <div class="mt-3">
                            <a href="{{ route('livres.search') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times"></i> Réinitialiser la recherche
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Résultats --}}
    @if($query)
        @if(count($livres) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <h3>
                    <i class="fas fa-book"></i> Résultats pour "{{ $query }}"
                    <span class="badge bg-secondary">{{ count($livres) }} résultat(s)</span>
                </h3>
            </div>
        </div>

        <div class="row">
            @foreach($livres as $livre)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $livre->titre }}</h5>
                        <p class="card-text text-muted small">
                            <i class="fas fa-pen"></i> {{ $livre->auteur ?? 'Auteur inconnu' }}
                        </p>
                        @if($livre->categorie)
                        <p class="card-text">
                            <span class="badge bg-info">{{ $livre->categorie->nom }}</span>
                        </p>
                        @endif
                        {{-- Espacement flexible pour pousser le bouton vers le bas --}}
                        <div class="mt-auto">
                            <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye"></i> Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> 
            <strong>Aucun résultat</strong><br>
            Aucun livre ne correspond à votre recherche "<strong>{{ $query }}</strong>".
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    @else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-search"></i> 
                <strong>Commencez votre recherche</strong><br>
                Entrez un titre, un auteur ou une catégorie pour trouver des livres.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection