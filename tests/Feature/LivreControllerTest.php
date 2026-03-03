<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreControllerTest extends TestCase
{
    use RefreshDatabase;

    private Categorie $categorie;
    private Livre $livre;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer une catégorie pour les tests
        $this->categorie = Categorie::factory()->create([
            'nom' => 'Science-Fiction',
            'slug' => 'science-fiction',
        ]);

        // Créer un livre pour les tests
        $this->livre = Livre::factory()->create([
            'categorie_id' => $this->categorie->id,
            'titre' => 'Dune',
            'auteur' => 'Frank Herbert',
        ]);
    }

    /**
     * Test: Liste des livres accessible
     * SÉANCE 5 : Test Feature - Routes publiques
     */
    public function test_index_affiche_liste_livres(): void
    {
        $response = $this->get('/livres');

        $response->assertStatus(200);
        $response->assertSee('Dune');
        $response->assertSee('Catalogue des livres');
    }

    /**
     * Test: Détail d'un livre accessible
     */
    public function test_show_affiche_details_livre(): void
    {
        $response = $this->get("/livres/{$this->livre->id}");

        $response->assertStatus(200);
        $response->assertSee('Dune');
        $response->assertSee('Frank Herbert');
    }

    /**
     * Test: Recherche fonctionne
     */
    public function test_search_retourne_resultats(): void
    {
        $response = $this->get('/recherche?q=Dune');

        $response->assertStatus(200);
        $response->assertSee('Dune');
    }

    /**
     * Test: Formulaire de création accessible
     */
    public function test_create_affiche_formulaire(): void
    {
        $response = $this->get('/livres/create');

        $response->assertStatus(200);
        $response->assertSee('Créer un nouveau livre');
        $response->assertSee('Titre');
    }

    /**
     * Test: Création de livre avec données valides
     */
    public function test_store_cree_livre_valide(): void
    {
        $data = [
            'titre' => 'Nouveau Livre',
            'auteur' => 'Auteur Test',
            'annee' => 2024,
            'nb_pages' => 350,
            'isbn' => '978-1234567890',
            'resume' => 'Un résumé de test',
            'categorie_id' => $this->categorie->id,
            'disponible' => true,
        ];

        $response = $this->post('/livres', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('livres', ['titre' => 'Nouveau Livre']);
    }

    /**
     * Test: Création rejette données invalides
     */
    public function test_store_rejette_donnees_invalides(): void
    {
        $data = [
            'titre' => '', // Titre vide
            'categorie_id' => 999, // Catégorie inexistante
        ];

        $response = $this->post('/livres', $data);

        $response->assertSessionHasErrors(['titre', 'categorie_id']);
        $this->assertDatabaseCount('livres', 1);
    }

    /**
     * Test: Formulaire d'édition accessible
     */
    public function test_edit_affiche_formulaire(): void
    {
        $response = $this->get("/livres/{$this->livre->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Modifier le livre');
        $response->assertSee($this->livre->titre);
    }

    /**
     * Test: Mise à jour d'un livre
     */
    public function test_update_modifie_livre(): void
    {
        $data = [
            'titre' => 'Dune - Édition Révisée',
            'auteur' => 'Frank Herbert',
            'annee' => 1965,
            'nb_pages' => 680,
            'categorie_id' => $this->categorie->id,
            'disponible' => true,
        ];

        $response = $this->put("/livres/{$this->livre->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('livres', ['titre' => 'Dune - Édition Révisée']);
    }

    /**
     * Test: Suppression d'un livre
     */
    public function test_destroy_supprime_livre(): void
    {
        $livreId = $this->livre->id;

        $response = $this->delete("/livres/{$livreId}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('livres', ['id' => $livreId]);
    }
}
