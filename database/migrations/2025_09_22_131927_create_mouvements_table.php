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
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            $table->date('date_mouvement');
            $table->integer('distance_parcourue'); // en kilomètres
            $table->string('destination')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Qui a enregistré le mouvement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements');
    }
};
