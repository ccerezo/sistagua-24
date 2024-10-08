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
        Schema::create('autorizas', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion',20)->nullable();
            $table->string('apellido1',50);
            $table->string('apellido2',50)->nullable();
            $table->string('nombre1',50);
            $table->string('nombre2',50)->nullable();
            $table->longText('firma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autorizas');
    }
};
