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
        Schema::create('actividads', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('icono')->nullable();
            $table->foreignId('actor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('afectado_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('accion');
            $table->boolean('leida')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividads');
    }
};
