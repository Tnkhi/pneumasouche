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
            
            // Champs de base
            $table->string('type_maintenance')->default('curative'); // preventive, curative
            $table->string('sous_type_curative')->nullable(); // Type d'intervention curative
            $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            
            // Champs de déclaration
            $table->text('prerequis'); // Besoins de base minimale
            $table->text('requis'); // Ce qu'il faut vraiment pour la maintenance
            $table->text('resultat_attendu'); // Résultat attendu
            $table->text('explication_cause'); // Explication sur la cause
            
            // Workflow
            $table->string('statut')->default('declaree'); // declaree, en_attente_validation, validee, terminee, rejetee
            $table->string('etape')->default('declarateur'); // declarateur, direction, terminee
            
            // Utilisateurs impliqués
            $table->foreignId('mecanicien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('declarateur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('direction_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Informations de validation
            $table->string('numero_reference')->nullable();
            $table->text('bon_necessaire')->nullable();
            $table->decimal('prix_maintenance', 10, 0)->nullable();
            $table->timestamp('date_validation_declarateur')->nullable();
            $table->timestamp('date_validation_direction')->nullable();
            $table->text('commentaire_direction')->nullable();
            $table->timestamp('date_finalisation')->nullable();
            $table->text('rapport_finalisation')->nullable();
            
            // Historique et métadonnées
            $table->json('historique_actions')->nullable();
            $table->string('pdf_path')->nullable();
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