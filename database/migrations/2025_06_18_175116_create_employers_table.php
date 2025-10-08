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
       Schema::create('employers', function (Blueprint $table) {
    $table->id();
    $table->string('nom'); // Colonne pour le nom
    $table->string('prenom'); // Colonne pour le prénom
    $table->string('email')->unique();
    $table->string('contact')->unique();
    $table->decimal('montant_journalier', 10, 2);
    $table->foreignId('departement_id')->constrained();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
