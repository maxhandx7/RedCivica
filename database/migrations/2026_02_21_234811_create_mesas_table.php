<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('puesto_votacion')->nullable();
            $table->string('mesa')->nullable();
            $table->string('zona')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};