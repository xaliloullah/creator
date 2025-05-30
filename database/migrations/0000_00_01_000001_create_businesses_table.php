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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('type');
            $table->string('designation');
            $table->string('email')->nullable();
            $table->string('titre')->nullable();
            $table->text('adresse')->nullable();
            $table->text('telephones')->nullable();
            $table->text('site_web')->nullable();
            $table->text('reseaux_sociaux')->nullable();
            $table->text('description')->nullable();
            $table->text('contact')->nullable();
            $table->text('parametre')->nullable();
            $table->text('contenue')->nullable();
            // $table->text('clients')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('statut')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
        });

        Schema::create('business_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('roles')->nullable();
            $table->text('permissions')->nullable();
            $table->text('parametre')->nullable();
            $table->text('statut')->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('business_membres');
    }
};
