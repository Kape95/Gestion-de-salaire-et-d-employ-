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
        Schema::table('employers', function (Blueprint $table) {
            $table->string('telephone')->nullable()->after('email');
            $table->text('adresse')->nullable()->after('telephone');
            $table->date('date_naissance')->nullable()->after('adresse');
            $table->date('date_embauche')->nullable()->after('date_naissance');
            $table->string('poste')->nullable()->after('date_embauche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn(['telephone', 'adresse', 'date_naissance', 'date_embauche', 'poste']);
        });
    }
};
