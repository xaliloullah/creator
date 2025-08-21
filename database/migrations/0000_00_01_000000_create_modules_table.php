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
        Schema::create('modules', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->unique();
            $table->string('designation');
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->string('statut')->nullable();
            $table->string('route')->nullable(); 
            $table->string('link')->nullable(); 
            $table->boolean('lock')->default(false);
            $table->boolean('hidden')->default(false);
            $table->string('target')->nullable();
            $table->foreignId('module_id')->nullable()->constrained('modules')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->json('tags')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
