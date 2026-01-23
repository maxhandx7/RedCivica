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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();$table->foreignId('candidato_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo'); // flyer, tarjeton, programa, otro
            $table->string('archivo');
            $table->string('formato')->nullable();
            $table->integer('tamano')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('publico')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
