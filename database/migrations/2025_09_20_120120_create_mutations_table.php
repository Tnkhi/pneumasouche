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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pneu_id')->constrained('pneus')->onDelete('cascade');
            $table->foreignId('vehicule_source_id')->nullable()->constrained('vehicules')->onDelete('set null');
            $table->foreignId('vehicule_destination_id')->constrained('vehicules')->onDelete('cascade');
            $table->date('date_mutation');
            $table->text('motif')->nullable(); // Raison de la mutation
            $table->string('kilometrage_au_moment_mutation')->nullable(); // Kilométrage du pneu au moment de la mutation
            $table->string('operateur')->nullable(); // Personne qui a effectué la mutation
            $table->text('observations')->nullable(); // Observations particulières
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
