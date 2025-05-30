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
        Schema::create('postes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('designation');
            $table->decimal('salaire', 12, 0);
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
        Schema::dropIfExists('postes');
    }
};
