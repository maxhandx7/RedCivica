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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->mediumText('mision')->nullable();
            $table->mediumText('vision')->nullable();
            $table->string('logo')->default('system/default.jpg');
            $table->string('mail')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('nit');
            $table->longText('configurations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
