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
        Schema::create('pieces_detachees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained()->onDelete('cascade');
            
            // Informations de la pièce
            $table->string('type_piece'); // Type de pièce détachée
            $table->string('marque'); // Marque
            $table->string('reference'); // Référence
            $table->string('constructeur')->nullable(); // Constructeur
            $table->string('fournisseur')->nullable(); // Fournisseur
            
            // Coûts et quantité
            $table->decimal('cout_unitaire', 10, 0); // Coût de la pièce
            $table->integer('nombre'); // Nombre
            $table->decimal('montant_total', 10, 0); // cout_unitaire * nombre
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces_detachees');
    }
};