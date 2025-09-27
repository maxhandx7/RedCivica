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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            // Datos básicos de la persona
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('email')->nullable();

            // Ubicación
            $table->string('pais')->nullable();
            $table->string('departamento')->nullable();
            $table->string('ciudad')->nullable();

            // Respuestas en JSON
            $table->json('respuestas');

            // Si en el futuro quieres vincularlo a un usuario logueado:
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
