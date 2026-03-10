@extends('layouts.app', [
    'title' => 'Catalogue des vinyles',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => null]
    ]
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

    {{-- En-tête avec statistiques et bouton créer --}}
    <div class="row mb-4 mt-4">
        <div class="col-12 col-md-8 text-center text-md-start">
            <h1 class="display-5 fw-bold text-dark mb-2">
                <i class="fas fa-record-vinyl"></i> Catalogue des vinyles
            </h1>
            <p class="text-muted fs-5">
                <i class="fas fa-record-vinyl"></i> {{ $stats['totalVinyles'] }} vinyles • 
                <i class="fas fa-check"></i> {{ $stats['vinylesDisponibles'] }} disponibles • 
                <i class="fas fa-folder"></i> {{ $stats['totalCategories'] }} catégories
            </p>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2 justify-content-center justify-content-md-end">
            <a href="{{ route('vinyles.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nouveau vinyle
            </a>
            <a href="{{ route('vinyles.search') }}" class="btn btn-outline-primary">
                <i class="fas fa-search"></i> Recherche
            </a>
        </div>
    </div>

    {{-- Liste des vinyles --}}
    <div class="row">
        @forelse($vinyles as $vinyle)
        <div class="col-md-6 col-lg-4 mb-4">
            <x-vinyle-card :vinyle="$vinyle" :show-details="true" />
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                Aucun vinyle n'est disponible pour le moment.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection