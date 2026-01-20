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
        Schema::create('propuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('categoria', [
                'seguridad',
                'educacion',
                'economia',
                'salud',
                'social',
                'justicia',
                'medio_ambiente',
                'infraestructura',
                'transparencia',
                'otros'
            ]);
            $table->string('icono')->default('fas fa-bullhorn');
            $table->string('color', 7)->default('#007bff');
            $table->integer('orden')->default(0);
            $table->boolean('destacada')->default(false);
            $table->json('metas')->nullable();
            $table->json('indicadores')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propuestas');
    }
};
