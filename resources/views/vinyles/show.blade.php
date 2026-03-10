@extends('layouts.app', [
    'title' => $vinyle->titre,
    'breadcrumbs' => [['label' => 'Catalogue', 'url' => route('vinyles.index')], ['label' => $vinyle->titre, 'url' => null]],
])

@section('content')
    <div class="container-fluid px-4">
        {{-- Messages flash --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row mt-4">
            {{-- Image du vinyle --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="vinyle-cover vinyle-cover-{{ $vinyle->categorie->slug ?? 'default' }}" style="height: 400px;">
                        <div class="vinyle-title" style="font-size: 18px;">{{ $vinyle->titre }}</div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2 mt-3">
                    @if ($vinyle->disponible)
                        <button class="btn btn-success">
                            <i class="fas fa-hand-holding"></i> Emprunter
                            <small>(Séance 4)</small>
                        </button>
                    @else
                        <button class="btn btn-warning" disabled>
                            <i class="fas fa-clock"></i> Non disponible
                        </button>
                    @endif

                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-heart"></i> Ajouter aux favoris
                        <small>(Séance 5)</small>
                    </button>
                </div>

                {{-- Boutons CRUD (Séance 3) --}}
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('vinyles.edit', $vinyle->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('vinyles.destroy', $vinyle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vinyle ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>

            {{-- Détails du vinyle --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">{{ $vinyle->titre }}</h1>
                        @if ($vinyle->disponible)
                            <span class="badge bg-success fs-6">Disponible</span>
                        @else
                            <span class="badge bg-warning fs-6">Emprunté</span>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h5><i class="fas fa-user"></i> Auteur</h5>
                                <p>{{ $vinyle->auteur }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h5><i class="fas fa-tag"></i> Catégorie</h5>
                                <span class="badge"
                                    style="background-color: {{ $vinyle->categorie->couleur ?? '#6c757d' }}">
                                    <i class="{{ $vinyle->categorie->icone ?? 'fas fa-tag' }}"></i>
                                    {{ $vinyle->categorie->nom ?? 'Non catégorisé' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h5><i class="fas fa-barcode"></i> Numéro de série</h5>
                                <p><code>{{ $vinyle->num_serie }}</code></p>
                            </div>
                            <div class="col-sm-6">
                                <h5><i class="fas fa-calendar"></i> Année</h5>
                                <p>{{ $vinyle->annee }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5><i class="fas fa-compact-disc"></i> Nombre de tours</h5>
                            <p>{{ $vinyle->nb_tours }} tours</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection