@extends('layouts.app', [
    'title' => 'Connexion',
    'breadcrumbs' => [
        ['label' => 'Connexion', 'url' => null]
    ]
])

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0"><i class="fas fa-sign-in-alt"></i> Connexion</h2>
                    <p class="mb-0 small mt-2">Connectez-vous à BiblioTech</p>
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

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

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
                                   placeholder="Votre mot de passe" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Se souvenir --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" 
                                       name="remember" value="1">
                                <label class="form-check-label" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        {{-- Bouton connexion --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </button>
                        </div>

                        {{-- Lien inscription --}}
                        <div class="text-center mt-4">
                            <p>Pas de compte ? <a href="{{ route('register') }}" class="text-primary fw-bold">Créer un compte</a></p>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center">
                    {{-- Utilisateurs de test --}}
                    <small class="text-muted d-block mb-2">
                        <strong>Comptes de test :</strong>
                    </small>
                    <small class="text-muted d-block">
                        User: <code>user@example.com</code> / <code>password</code>
                    </small>
                    <small class="text-muted">
                        Admin: <code>admin@example.com</code> / <code>password</code>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
