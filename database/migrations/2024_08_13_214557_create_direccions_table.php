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
        Schema::create('direccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciudad_id')->nullable()->constrained('ciudads')->nullOnDelete();
            $table->foreignId('parroquia_id')->nullable()->constrained('parroquias')->nullOnDelete();
            $table->string('direccion',150)->nullable();
            $table->string('referencia',200)->nullable();
            $table->string('ubicacion',180)->nullable();
            $table->string('latitud',80)->nullable();
            $table->string('longitud',80)->nullable();
            $table->boolean('equipos_instalados')->default(true);
            $table->morphs('direccionable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
