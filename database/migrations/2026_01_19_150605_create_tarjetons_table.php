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
        Schema::create('tarjetons', function (Blueprint $table) {
            $table->id(); $table->foreignId('candidato_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->integer('total_opciones')->default(100);
            $table->string('instruccion')->nullable();
            $table->json('secciones');
            $table->json('configuracion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetons');
    }
};
