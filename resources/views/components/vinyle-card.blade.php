{{-- Composant carte vinyle pour BiblioTech --}}
<div class="card h-100 shadow-sm">
    <div class="vinyle-cover vinyle-cover-{{ $vinyle->categorie->slug ?? 'default' }}">
        <div class="vinyle-title">{{ $vinyle->titre ?? 'Vinyle' }}</div>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $vinyle->titre ?? 'Titre non disponible' }}</h5>
        <p class="card-text text-muted">{{ $vinyle->auteur ?? 'Auteur inconnu' }}</p>

        @if ($vinyle->categorie)
            <span class="badge mb-2" style="background-color: {{ $vinyle->categorie->couleur }}; width: fit-content;">
                <i class="{{ $vinyle->categorie->icone }}"></i>
                {{ $vinyle->categorie->nom }}
            </span>
        @endif

        <div class="mt-auto">
            <a href="{{ route('vinyles.show', $vinyle->id) }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> Voir détails
            </a>
        </div>
    </div>
</div>