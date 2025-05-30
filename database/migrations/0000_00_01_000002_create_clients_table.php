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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignUuid('business_id')->constrained('businesses')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('telephone')->nullable()->unique();
            $table->text('adresse')->nullable();
            $table->string('fonction')->nullable();
            $table->string('civilite')->nullable();
            $table->string('site_web')->nullable();
            $table->text('reseaux_sociaux')->nullable();
            $table->text('description')->nullable();
            $table->string('ip')->nullable()->unique();
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
        Schema::dropIfExists('clients');
    }
};
