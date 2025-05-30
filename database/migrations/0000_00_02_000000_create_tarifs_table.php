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
        Schema::create('tarifs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('designation')->unique(); 
            $table->decimal('prix', 10, 2);
            $table->integer('duree')->default(1);
            $table->integer('reduction')->nullable();
            $table->text('description')->nullable();
            $table->text('parametre')->nullable();
            $table->text('roles')->nullable();
            $table->text('permissions')->nullable();
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
        Schema::dropIfExists('tarifs');
    }
};
