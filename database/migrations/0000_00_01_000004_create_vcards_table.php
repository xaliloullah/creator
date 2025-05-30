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
        Schema::create('vcards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('email')->nullable();
            $table->string('organisation')->nullable();
            $table->string('titre')->nullable();
            $table->text('adresse')->nullable();
            $table->text('telephones')->nullable();
            $table->text('site_web')->nullable();
            $table->text('reseaux_sociaux')->nullable();
            $table->text('description')->nullable();
            $table->text('contact')->nullable();
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
        Schema::dropIfExists('vcards');
    }
};
