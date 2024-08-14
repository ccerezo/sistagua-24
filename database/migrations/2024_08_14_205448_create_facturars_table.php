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
        Schema::create('facturars', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion',15);
            $table->string('nombre',100);
            $table->string('direccion',200)->nullable();
            $table->json('correo')->nullable();
            $table->json('celular')->nullable();
            $table->json('telefono')->nullable();
            $table->morphs('facturarable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturars');
    }
};
