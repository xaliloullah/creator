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
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('email')->nullable();
            $table->text('telephones')->nullable();
            $table->string('titre')->nullable();
            $table->text('adresse')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->text('experiences')->nullable();
            $table->text('competences')->nullable();
            $table->text('formations')->nullable();
            $table->text('certifications')->nullable();
            $table->text('permis')->nullable();
            $table->text('projets')->nullable();
            $table->text('langues')->nullable();
            $table->text('interets')->nullable();
            $table->text('liens')->nullable();
            $table->text('reseaux_sociaux')->nullable();
            $table->text('description')->nullable();
            $table->text('parametre')->nullable();
            $table->text('statut')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
