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
        Schema::create('metricas', function (Blueprint $table) {
            $table->id();$table->foreignId('candidato_id')->constrained()->onDelete('cascade');
            $table->string('tipo_metrica');
            $table->string('nombre');
            $table->decimal('valor', 15, 2);
            $table->string('unidad')->nullable();
            $table->date('fecha_medicion');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['candidato_id', 'tipo_metrica', 'fecha_medicion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metricas');
    }
};
