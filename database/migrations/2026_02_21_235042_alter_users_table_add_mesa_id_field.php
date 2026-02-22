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
         Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mesa');
            $table->foreignId('mesa_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('mesas')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['mesa_id']);
            $table->dropColumn('mesa_id');
            $table->string('mesa')->nullable();
        });
    }
};
