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
        Schema::create('contrats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignUuid('business_id')->constrained('businesses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->string('numero')->unique();
            $table->string('designation');
            $table->date('date')->nullable();
            $table->string('lieu')->nullable();
            $table->text('articles');
            $table->text('signature')->nullable();
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
        Schema::dropIfExists('contrats');
    }
};
