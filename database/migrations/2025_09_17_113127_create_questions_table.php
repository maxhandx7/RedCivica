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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas opcionales
            $table->integer('city_id');

            $table->integer('department_id');

            // Campos propios
            $table->string('question_text');               // texto de la pregunta
            $table->string('question_type')->nullable();   // ej: multiple_choice, open, etc.
            $table->json('options')->nullable();           // opciones si aplica
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
