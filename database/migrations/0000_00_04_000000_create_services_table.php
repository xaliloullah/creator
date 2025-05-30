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
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('designation');
            $table->string('type'); 
            $table->text('description')->nullable();
            $table->text('parametre')->nullable();
            $table->text('statut')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();
        });

        // Schema::create('produit_service', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignUuid('service_id')->nullable()->constrained('services')->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreignUuid('produit_id')->nullable()->constrained('produits')->onUpdate('cascade')->onDelete('cascade');
        //     $table->string('statut')->default('ACTIVE');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
