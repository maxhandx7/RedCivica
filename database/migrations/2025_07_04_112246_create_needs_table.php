<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referido_id'); // usuario que tiene la necesidad (o sea, el "nieto")
            $table->unsignedBigInteger('registrado_por'); // usuario que reporta la necesidad (el hijo)
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['pendiente', 'en proceso', 'resuelta'])->default('pendiente');
            $table->timestamps();

            $table->foreign('referido_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('registrado_por')->references('id')->on('users')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs');
    }
};
