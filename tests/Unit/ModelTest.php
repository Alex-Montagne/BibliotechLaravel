<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Livre appartient à une Categorie
     * SÉANCE 5 : Test Unit - Relations Eloquent
     */
    public function test_livre_has_categorie(): void
    {
        $categorie = Categorie::factory()->create();
        $livre = Livre::factory()->create(['categorie_id' => $categorie->id]);

        $this->assertNotNull($livre->categorie);
        $this->assertEquals($categorie->id, $livre->categorie->id);
    }

    /**
     * Test: Categorie a plusieurs Livres
     */
    public function test_categorie_has_many_livres(): void
    {
        $categorie = Categorie::factory()->create();
        Livre::factory(3)->create(['categorie_id' => $categorie->id]);

        $this->assertCount(3, $categorie->livres);
    }

    /**
     * Test: Scope disponible fonctionne
     */
    public function test_livre_scope_disponible(): void
    {
        Livre::factory()->create(['disponible' => true]);
        Livre::factory()->create(['disponible' => false]);
        Livre::factory()->create(['disponible' => true]);

        $disponibles = Livre::disponible()->get();

        $this->assertCount(2, $disponibles);
        $this->assertTrue($disponibles->every(fn($l) => $l->disponible));
    }

    /**
     * Test: Scope recherche fonctionne par titre
     */
    public function test_livre_scope_recherche_par_titre(): void
    {
        Livre::factory()->create(['titre' => 'Dune']);
        Livre::factory()->create(['titre' => 'Foundation']);
        Livre::factory()->create(['titre' => 'Dune Messiah']);

        $resultats = Livre::recherche('Dune')->get();

        $this->assertCount(2, $resultats);
    }

    /**
     * Test: Scope recherche fonctionne par auteur
     */
    public function test_livre_scope_recherche_par_auteur(): void
    {
        Livre::factory()->create(['auteur' => 'Frank Herbert']);
        Livre::factory()->create(['auteur' => 'Isaac Asimov']);
        Livre::factory()->create(['auteur' => 'Frank Kafka']);

        $resultats = Livre::recherche('Frank')->get();

        $this->assertCount(2, $resultats);
    }

    /**
     * Test: User peut avoir un rôle
     */
    public function test_user_has_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $biblio = User::factory()->create(['role' => 'bibliothécaire']);

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($user->isUser());
        $this->assertTrue($biblio->isBibliothecaire());
    }

    /**
     * Test: Validation des attributs fillable
     */
    public function test_livre_fillable_attributes(): void
    {
        $categorie = Categorie::factory()->create();
        
        $data = [
            'titre' => 'Test Livre',
            'auteur' => 'Test Auteur',
            'annee' => 2024,
            'nb_pages' => 300,
            'isbn' => '123-456-789',
            'resume' => 'Test résumé',
            'disponible' => true,
            'categorie_id' => $categorie->id,
        ];

        $livre = Livre::factory()->create($data);

        $this->assertEquals('Test Livre', $livre->titre);
        $this->assertEquals('Test Auteur', $livre->auteur);
        $this->assertEquals(2024, $livre->annee);
    }

    /**
     * Test: Catégorie scope actives
     */
    public function test_categorie_scope_actives(): void
    {
        Categorie::factory()->create(['active' => true]);
        Categorie::factory()->create(['active' => false]);
        Categorie::factory()->create(['active' => true]);

        $actives = Categorie::actives()->get();

        $this->assertCount(2, $actives);
    }

    /**
     * Test: User password hashing
     */
    public function test_user_password_hashed(): void
    {
        $user = User::factory()->create(['password' => 'plaintext']);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(password_verify('plaintext', $user->password) || 
                         \Hash::check('plaintext', $user->password));
    }
}
