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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('alias')->nullable();
            $table->enum('cargo', ['senador', 'representante', 'presidente', 'gobernador', 'alcalde']);
            $table->string('circunscripcion');
            $table->string('partido');
            $table->string('lema')->nullable();
            $table->string('color_principal', 7)->default('#007bff');
            $table->string('imagen')->nullable();
            $table->text('biografia')->nullable();
            $table->date('fecha_eleccion');
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
