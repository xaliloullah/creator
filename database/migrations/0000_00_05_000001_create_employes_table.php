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
        Schema::create('employes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image')->nullable();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('adresse')->nullable();
            $table->string('contact')->nullable();
            $table->foreignUuid('poste_id')->constrained('postes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('contrat_id')->nullable()->constrained('contrats')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sexe')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('cni')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('filiation')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('categorie_professionnelle')->nullable();
            $table->string('profession')->nullable();
            $table->string('duree_contrat')->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_engagement')->nullable();
            $table->string('justificatif')->nullable();
            $table->string('signature')->nullable();
            $table->text('description')->nullable();
            $table->text('statut')->nullable();
            $table->text('parametre')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
