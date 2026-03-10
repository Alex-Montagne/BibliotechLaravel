@extends('layouts.app', [
    'title' => 'Inscription',
    'breadcrumbs' => [
        ['label' => 'Inscription', 'url' => null]
    ]
])

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0"><i class="fas fa-user-plus"></i> Inscription</h2>
                    <p class="mb-0 small mt-2">Créez votre compte BiblioTech</p>
                </div>

                <div class="card-body p-5">
                    {{-- Messages d'erreur --}}
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <strong>Erreur !</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        {{-- Nom --}}
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Nom complet</strong></label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Jean Dupont" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="vous@example.com" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mot de passe --}}
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>Mot de passe</strong></label>
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Minimum 8 caractères" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> 
                                Le mot de passe doit contenir au moins 8 caractères, avec majuscules et caractères spéciaux.
                            </small>
                        </div>

                        {{-- Confirmation mot de passe --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label"><strong>Confirmer le mot de passe</strong></label>
                            <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Répétez votre mot de passe" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Inscription vinyles --}}
                        <div class="mb-4">
                            <input type="checkbox" class="form-check-input @error('vinyle') is-invalid @enderror" id="vinyle" name="vinyle" value="1">
                            <label class="form-check-label" for="vinyle">Je m'inscris pour accéder aux vinyles</label>
                        </div>

                        {{-- Bouton inscription --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus"></i> Créer mon compte
                            </button>
                        </div>

                        {{-- Lien connexion --}}
                        <div class="text-center mt-4">
                            <p>Vous avez déjà un compte ? <a href="{{ route('login') }}" class="text-primary fw-bold">Se connecter</a></p>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        <i class="fas fa-lock"></i> Votre compte est sécurisé et protégé par chiffrement.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
