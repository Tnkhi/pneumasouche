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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            
            // Référence au pneu
            $table->foreignId('pneu_id')->constrained('pneus')->onDelete('cascade');
            
            // Workflow et états
            $table->enum('statut', ['declaree', 'en_attente_validation', 'validee', 'terminee', 'rejetee'])->default('declaree');
            $table->enum('etape', ['mecanicien', 'declarateur', 'direction', 'terminee'])->default('mecanicien');
            
            // Données du mécanicien
            $table->foreignId('mecanicien_id')->constrained('users')->onDelete('cascade');
            $table->text('motif_maintenance');
            $table->text('description_probleme')->nullable();
            $table->timestamp('date_declaration')->useCurrent();
            
            // Données du déclarateur
            $table->foreignId('declarateur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('numero_reference')->nullable();
            $table->text('bon_necessaire')->nullable();
            $table->decimal('prix_maintenance', 10, 2)->nullable();
            $table->timestamp('date_validation_declarateur')->nullable();
            
            // Données de la direction
            $table->foreignId('direction_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('commentaire_direction')->nullable();
            $table->timestamp('date_validation_direction')->nullable();
            
            // Données de finalisation
            $table->text('rapport_finalisation')->nullable();
            $table->timestamp('date_finalisation')->nullable();
            
            // Historique des actions
            $table->json('historique_actions')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
