@extends('layouts.app', ['title' => 'Accueil'])

@section('content')
<div class="container-fluid px-4 py-5">
    {{-- Hero Section --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-gradient bg-primary text-white rounded-3 p-5 text-center shadow-lg">
                <h1 class="display-4 mb-3 fw-bold">
                    <i class="fas fa-book-open"></i>
                    Bienvenue sur BiblioTech
                </h1>
                <p class="lead mb-4">
                    Votre système de gestion de bibliothèque moderne, développé avec Laravel
                </p>
                <p class="text-light mb-4">
                    Un projet pédagogique pour apprendre les concepts de Laravel (MVC, Eloquent, Authentication)
                </p>
                <a href="{{ route('livres.index') }}" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-book"></i> Explorer le Catalogue
                </a>
                <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-info-circle"></i> En Savoir Plus
                </a>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">
                <i class="fas fa-chart-bar text-primary"></i>
                Statistiques BiblioTech
            </h2>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-primary shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    <h3 class="text-primary">{{ $stats['totalLivres'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Livres au total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-success shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h3 class="text-success">{{ $stats['livresDisponibles'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Livres disponibles</p>
                </div>
            </div>
        </div>
        @if(Auth::check() && Auth::user()->isVinyleUser())
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-secondary shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-record-vinyl fa-3x text-secondary mb-3"></i>
                    <h3 class="text-secondary">{{ $stats['totalVinyles'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Vinyles au total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-info shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-compact-disc fa-3x text-info mb-3"></i>
                    <h3 class="text-info">{{ $stats['vinylesDisponibles'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Vinyles disponibles</p>
                </div>
            </div>
        </div>
        @else()
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-warning shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-hand-holding-book fa-3x text-warning mb-3"></i>
                    <h3 class="text-warning">{{ $stats['totalEmprunts'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Emprunts actifs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-info shadow-sm hover-shadow">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h3 class="text-info">{{ $stats['totalUtilisateurs'] }}</h3>
                    <p class="card-text text-muted fw-semibold">Utilisateurs</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Livres mis en avant --}}
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2>
                <i class="fas fa-star text-warning"></i>
                Livres Recommandés
            </h2>
            <p class="text-muted">Découvrez une sélection de nos livres les plus populaires</p>
        </div>
        
        @if($livresEnVedette && $livresEnVedette->count() > 0)
            @foreach($livresEnVedette as $livre)
            <div class="col-md-4 mb-4">
                <x-livre-card :livre="$livre" />
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i>
                    Aucun livre disponible pour le moment.
                </div>
            </div>
        @endif
    </div>

    {{-- Vinyles mis en avant --}}
    @if(Auth::check() && Auth::user()->isVinyleUser())
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2>
                <i class="fas fa-record-vinyl text-secondary"></i>
                Vinyles Recommandés
            </h2>
            <p class="text-muted">Découvrez une sélection de nos vinyles les plus populaires</p>
        </div>

        @if($vinylesEnVedette && $vinylesEnVedette->count() > 0)
            @foreach($vinylesEnVedette as $vinyle)
            <div class="col-md-4 mb-4">
                <x-vinyle-card :vinyle="$vinyle" />
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i>
                    Aucun vinyle disponible pour le moment.
                </div>
            </div>
        @endif
    </div>
    @endif

    {{-- Appel à l'action & Fonctionnalités --}}
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <h3 class="mb-3">
                        <i class="fas fa-rocket text-primary"></i>
                        Découvrir BiblioTech
                    </h3>
                    <p class="lead text-muted mb-4">
                        Explorez notre catalogue complet ou apprenez-en plus sur notre système
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('livres.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-book"></i> Voir tous les livres
                        </a>
                        @if(Auth::check() && Auth::user()->isVinyleUser())
                        <a href="{{ route('vinyles.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-record-vinyl"></i> Voir tous les vinyles
                        </a>
                        @endif
                        <a href="{{ route('livres.search') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-search"></i> Recherche avancée
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-info btn-lg">
                            <i class="fas fa-info-circle"></i> À propos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Caractéristiques BiblioTech --}}
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="text-center mb-4">Pourquoi BiblioTech ?</h2>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-search-plus fa-2x text-primary mb-3"></i>
                    <h5 class="card-title">Recherche Facile</h5>
                    <p class="card-text text-muted">Trouvez rapidement les livres que vous cherchez</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-lock fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Sécurisé</h5>
                    <p class="card-text text-muted">Authentification sécurisée avec Laravel</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-mobile-alt fa-2x text-info mb-3"></i>
                    <h5 class="card-title">Responsive</h5>
                    <p class="card-text text-muted">Accessible sur tous les appareils</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-graduation-cap fa-2x text-warning mb-3"></i>
                    <h5 class="card-title">Pédagogique</h5>
                    <p class="card-text text-muted">Projet d'apprentissage complet pour BTS SIO</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection