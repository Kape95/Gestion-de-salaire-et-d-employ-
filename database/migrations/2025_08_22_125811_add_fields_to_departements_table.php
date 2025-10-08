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
        Schema::table('departements', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->decimal('budget_mensuel', 10, 2)->nullable()->after('description');
            $table->unsignedBigInteger('responsable_id')->nullable()->after('budget_mensuel');
            $table->enum('status', ['actif', 'inactif'])->default('actif')->after('responsable_id');
            $table->string('couleur', 7)->nullable()->after('status');
            
            $table->foreign('responsable_id')->references('id')->on('employers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropColumn(['description', 'budget_mensuel', 'responsable_id', 'status', 'couleur']);
        });
    }
};
