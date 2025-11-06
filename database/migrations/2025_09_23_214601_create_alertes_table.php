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
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('message');
            $table->enum('type', ['info', 'warning', 'danger', 'success']);
            $table->enum('priorite', ['faible', 'moyenne', 'haute', 'critique']);
            $table->enum('statut', ['active', 'resolue', 'ignoree'])->default('active');
            $table->string('categorie'); // 'usure', 'maintenance', 'mutation', 'stock', 'performance'
            $table->json('donnees_contexte')->nullable(); // Données supplémentaires pour l'alerte
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pneu_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('vehicule_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('maintenance_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('date_resolution')->nullable();
            $table->text('commentaire_resolution')->nullable();
            $table->timestamps();
            
            $table->index(['statut', 'priorite']);
            $table->index(['categorie', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};
