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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Type d'action (create, update, delete, etc.)
            $table->string('model_type'); // Type de modèle (Pneu, Vehicule, etc.)
            $table->unsignedBigInteger('model_id')->nullable(); // ID de l'objet concerné
            $table->string('title'); // Titre de la notification
            $table->text('message'); // Message détaillé
            $table->string('icon')->default('fas fa-info-circle'); // Icône FontAwesome
            $table->string('color')->default('info'); // Couleur Bootstrap (success, warning, danger, info)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui a effectué l'action
            $table->json('data')->nullable(); // Données supplémentaires (JSON)
            $table->boolean('is_read')->default(false); // Notification lue ou non
            $table->timestamp('read_at')->nullable(); // Date de lecture
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['user_id', 'is_read']);
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
