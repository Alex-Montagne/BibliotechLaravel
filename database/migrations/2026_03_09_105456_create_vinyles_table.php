<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vinyles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('auteur');
            $table->year('annee')->nullable();
            $table->integer('nb_tours')->nullable();
            $table->string('num_serie')->nullable()->unique();
            $table->boolean('disponible')->default(true);
            $table->foreignId('categorie_id')->nullable()->constrained('categories');
            $table->timestamps();

            // Index pour améliorer les recherches
            $table->index(['titre', 'auteur']);
            $table->index('disponible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinyles');
    }
};
