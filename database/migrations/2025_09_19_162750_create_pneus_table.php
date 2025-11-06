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
        Schema::create('pneus', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie')->unique();
            $table->decimal('prix_achat', 10, 2);
            $table->date('date_montage');
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->onDelete('cascade');
            $table->string('marque');
            $table->integer('largeur');
            $table->integer('hauteur_flanc');
            $table->integer('diametre_interieur');
            $table->string('indice_vitesse');
            $table->string('indice_charge');
            $table->integer('duree_vie'); // en kilomètres
            $table->integer('kilometrage')->default(0);
            $table->foreignId('vehicule_id')->constrained('vehicules')->onDelete('cascade');
            $table->decimal('taux_usure', 5, 2)->default(0); // calculé automatiquement
            $table->decimal('valeur_exploitation_restante', 10, 2)->default(0); // calculé automatiquement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pneus');
    }
};
