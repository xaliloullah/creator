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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('categorie_id')->nullable()->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('designation')->unique();
            $table->text('description')->nullable();
            $table->text('parametre')->nullable();
            $table->string('tags')->nullable();
            $table->text('statut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
