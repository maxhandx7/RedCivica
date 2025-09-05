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
        Schema::table('users', function (Blueprint $table) {
            // 🔹 Primero eliminamos el índice único si existe
            $table->dropUnique('users_email_unique');

            // 🔹 Luego modificamos email para que sea nullable
            $table->string('email')->nullable()->change();

            // 🔹 Nuevos campos
            if (!Schema::hasColumn('users', 'fecha_nacimiento')) {
                $table->date('fecha_nacimiento')->nullable()->after('cedula');
            }
            if (!Schema::hasColumn('users', 'fecha_expedicion')) {
                $table->date('fecha_expedicion')->nullable()->after('fecha_nacimiento');
            } 
            if (!Schema::hasColumn('users', 'tipo_documento')) {
                $table->string('tipo_documento')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->unique()->change();
            $table->dropColumn(['fecha_nacimiento', 'fecha_expedicion', 'tipo_documento']);
        });
    }
};
