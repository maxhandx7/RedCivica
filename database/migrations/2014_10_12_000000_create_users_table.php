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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('cedula')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('barrio')->nullable();
            $table->enum('estado',['activo', 'inactivo'])->default('activo'); 
            /* $table->string('departamento')->nullable();
            $table->string('pais')->default('Colombia');
            $table->string('codigo_postal')->nullable();
            $table->string('genero')->nullable();
            $table->date('fecha_nacimiento')->nullable();
             // Default state is 'activo'
            $table->string('foto')->nullable();
            $table->string('firma')->nullable(); */
            $table->string('mesa')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->foreign('parent_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
